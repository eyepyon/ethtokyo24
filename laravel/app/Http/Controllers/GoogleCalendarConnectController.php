<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\GoogleCalendarInfo;
use App\Models\GoogleConnectInfo;
use App\Services\GoogleClientStoreService;
use App\Services\GoogleCalendarDeleteService;
use App\Services\GoogleCalendarDeleteWithRefreshTokenCheckService;

class GoogleCalendarConnectController extends Controller
{
    public function store(Request $request)
    {
//        // temporarySignedRouteのチェックがあるが略
        $roomId = intval($request->input('room_id'));
        $room = Room::find($request->$roomId);

        $connect = new GoogleConnectInfo();
        $LENGTH = 16;
        $sessionStateToken = bin2hex(random_bytes($LENGTH));

        $connect->updateOrCreate([
            'room_id' => $roomId
        ],
            [
                'session_state_token' => $sessionStateToken
            ]);

        $client = (new GoogleClientStoreService())->execute(route('student.google')); // actionでもok
        $client->setState($sessionStateToken);

        return redirect()->away($client->createAuthUrl());
    }

    public function destroy(Request $request)
    {
        // temporarySignedRouteのチェックがあるが略
        $roomId = intval($request->input('room_id'));
        $room = Room::find($request->$roomId);

        $user = Auth::user();

        $client = (new GoogleClientStoreService())->execute(route('student.google_calendar_destroy'));
        $result = (new GoogleCalendarDeleteWithRefreshTokenCheckService())->execute($user, $client, $user->googleInfo()->first(), $room);

        if ($result['success'] === false) {
            return redirect('/student/dashboard')->with('appErrors', $result['message']);
        }

        $response = \DB::transaction(function () use ($user, $room, $result) {
            return (new GoogleCalendarDeleteService())->execute($user, $room, $result['service']);
        });

        if ($response) {
            return redirect('/student/dashboard')->with('message', 'googleカレンダーの予定を削除しました。');
        } else {
            return redirect('/student/dashboard')->with('appErrors', ['googleカレンダーの予定の削除に失敗しました。再度お試しください。']);
        }
    }
}


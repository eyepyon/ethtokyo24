<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\GoogleCalendarConnectCheckService;
use App\Services\GoogleCalendarStoreService;
use App\Models\Room;
use App\Models\GoogleConnectInfo;

class GoogleCalendarController extends Controller
{
    public function index(Request $request)
    {

        $room = Room::find($request->input('room_id'));

        $params = $request->all();

//        $user = Auth::user();
//
//        $classId = $user->googleConnectInfo->class_id;

        $result = (new GoogleCalendarConnectCheckService())
            ->execute($user, $params, $classId, route('student.google'));

        if ($result['success'] === false) {
            return redirect('/student/dashboard')->with('appErrors', $result['message']);
        }

//        $class = class::find($classId);
        \DB::transaction(function () use ($result, $user, $room) {
            (new GoogleCalendarStoreService())->execute($result['client'], $user, $room, $result['token']);
        });

        return redirect('/student/dashboard')->with('message', 'googleカレンダーに予定を追加しました。');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $address = "";
        if(isset($request->address)){
            $address = trim($request->address);
        }

        $user = Auth::user();
        if($address !=""){
            $user->wallet = $address;
            $user->save();
        }

        return view('home',compact('user'));
    }

    public function terms()
    {
        return view('terms');
    }

    public function privacy()
    {
        return view('privacy');
    }

    private function __getSymbolBalance()
    {


// 入力テキストデータ
        $inputText = <<<DATA
Account Information
┌───────────────────┬──────────────────────────────────────────────────────────────────┐
│ Property          │ Value                                                            │
├───────────────────┼──────────────────────────────────────────────────────────────────┤
│ Address           │ NCF3EF-NTCESH-2D7B6H-6AFDHM-U3P63Z-VROVNM-GTA                    │
│ Address Height    │ 3144559                                                          │
│ Public Key        │ 017020405597D9FA06F90AF75AAE07F3B3888492786B87A2DEA3D109CFC37BF8 │
│ Public Key Height │ 3147785                                                          │
│ Importance        │ 0                                                                │
│ Importance Height │ 0                                                                │
└───────────────────┴──────────────────────────────────────────────────────────────────┘
Balance Information
┌──────────────────┬─────────────────┬─────────────────┬───────────────────┐
│ Mosaic Id        │ Relative Amount │ Absolute Amount │ Expiration Height │
├──────────────────┼─────────────────┼─────────────────┼───────────────────┤
│ 6BED913FA20223F8 │ 92.7            │ 92700264        │ Never             │
└──────────────────┴─────────────────┴─────────────────┴───────────────────┘
DATA;
        //
        $inputTextFile = file_get_contents("/var/www/yaseme/files/bank.txt");

        // データを行に分割
        $lines = explode("\n", $inputTextFile);

        // 配列を初期化
        $accountInfo = [];
        $balanceInfo = [];
        $isBalanceSection = false; // バランス情報セクションのフラグ

        foreach ($lines as $lineX) {
            $line = trim(mb_convert_encoding($lineX,"utf-8","auto"));
            // セクションの切り替え
            if (strpos($line, 'Balance Information') !== false) {
                $isBalanceSection = true;
            }

            // データ行の解析
            if (preg_match('/│(.*?)+│(.*?)+│/', $line, $matches)) {
                if (!$isBalanceSection) {
                    // アカウント情報の抽出
                    $accountInfo[$matches[1]] = trim($matches[2]);
                } else {
                    // バランス情報の抽出
                    // このスクリプトでは、最初のバランス情報のみを抽出します。
                    // 複数行を解析する場合は、ロジックの調整が必要です。
                    $balanceInfo[$matches[1]] = trim($matches[2]);
                }
            }
        }

        // 結果の出力
        echo "Account Information:\n";
        print_r($accountInfo);
        echo "Balance Information:\n";
        print_r($balanceInfo);


    }

}

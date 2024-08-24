<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Door;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($apiKey, $secretKey, $uuid)
//    public function __construct()
    {
        $this->middleware('auth');

        $this->apiKey = $apiKey;
        $this->secretKey = $secretKey;
        $this->uuid = $uuid;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $address = "";
        if (isset($request->address)) {
            $address = trim($request->address);
        }

        $user = Auth::user();
        if ($address != "") {
            $user->wallet = $address;
            $user->save();
        }
        $address = "0xD47C631D51c51Fb640Fc90cD32B2218539A370EF";
        $id = date("YmdHis");

        $balanceEther = $this->__getScrollBalance($address, $id);// SepoliaETH

        return view('home', compact('user'));
    }

    public function terms()
    {
        return view('terms');
    }

    public function privacy()
    {
        return view('privacy');
    }


    /**
     * Cabinet経由でScrollを参照する
     * @see https://github.com/drlecks/Simple-Web3-Php
     * @param $address
     * @param $id
     * @return void
     */
    private function __getScrollBalance($address = "0xD47C631D51c51Fb640Fc90cD32B2218539A370EF", $id = 1)
    {
        //  https://document.cabinet-node.com/eth_getbalance

        $token = "c6bb7b3b5f1cfd35ae7d146ab5ec8138"; // テストネットだし無料垢なのでトークンは隠さないけど本来は隠して
        // cabinet-node.comのURLを設定
        $url = 'https://gateway-api.cabinet-node.com/' . $token;

        // JSONリクエストデータを準備
        $data = json_encode([
            'jsonrpc' => '2.0',
            'method' => 'eth_getBalance',
            'params' => [
                $address,
//              'latest'
            ],
            'id' => $id
        ]);

        // cURLセッションを初期化
        $ch = curl_init();

        // cURLオプションを設定
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);  // SSL証明書の検証を有効化

        // リクエストを実行し、レスポンスを取得
        $response = curl_exec($ch);

        // エラーチェック
        if (curl_errno($ch)) {
            echo 'cURLエラー: ' . curl_error($ch);
        } else {
            // レスポンスをJSONデコード
            $result = json_decode($response, true);

            if (isset($result['result'])) {
                // 16進数の結果をデコード
                $balanceWei = hexdec($result['result']);
                $balanceEther = $balanceWei / 1e18;  // WeiからEtherに変換
                echo "残高: " . $balanceEther . " ETH";
            } else {
                echo "エラー: " . json_encode($result['error']);
            }
        }

        // cURLセッションを閉じる
        curl_close($ch);

        return $balanceEther;
    }


    /**
     * @param $apiKey
     * @param $uuid
     * @return mixed
     */
    private function __getStatus($apiKey, $uuid)
    {
        return $this->__sendRequest('GET',   null, $apiKey);
    }

    /**
     * @param $apiKey
     * @param $secretKey
     * @param $uuid
     * @param $command
     * @return mixed
     */
    private function __control($apiKey, $secretKey, $uuid, $command)
    {
        $sign = $this->__generateSign($secretKey, $uuid);
        $data = [
            'sign' => $sign,
            'cmd' => $command
        ];
        return $this->__sendRequest('POST', $data, $apiKey);
    }

    /**
     * @param $secretKey
     * @param $uuid
     * @return string
     */
    private function __generateSign($secretKey, $uuid)
    {
        $timestamp = time() * 1000; // Current time in milliseconds
        $message = $uuid . $timestamp;
        $cmac = hash_hmac('cmac-aes-128', $message, hex2bin($secretKey));
        return base64_encode(hex2bin($cmac)) . $timestamp;
    }

    /**
     * @param $method
     * @param $data
     * @param $apiKey
     * @return mixed
     */
    private function __sendRequest($method, $data = null, $apiKey)
    {

        $url = 'https://app.candyhouse.co/api/sesame2/';
        $headers = [
            'x-api-key: ' . $apiKey
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        if ($httpCode >= 400) {
            throw new Exception("API request failed with status code: $httpCode");
        }

        return json_decode($response, true);
    }

    public function request_smart_key()
    {
        // Usage example
        $apiKey = '';
        $deviceSecret = '';
        $deviceUuid = '';

        $Door = Door::Select()->where('id',1 )->first();
        if(isset($Door->device_uuid)){
            $apiKey = $Door->api_key;
            $deviceUuid = $Door->device_uuid;
            $deviceSecret = $Door->device_seceret;
        }

        if($apiKey == ""){
            exit;
        }

        try {
            // Get lock status
            $status = $this->__getStatus($apiKey, $deviceUuid);
            echo "Battery: " . $status['battery'] . "%\n";
            echo "Lock status: " . ($status['locked'] ? 'Locked' : 'Unlocked') . "\n";

            // Unlock the door
            $result = $this->__control($apiKey, $deviceSecret, $deviceUuid, 'unlock');
            echo "Unlock command sent.\n";

            // Wait for a few seconds
            sleep(5);

            // Lock the door
            $result = $this->__control($apiKey, $deviceSecret, $deviceUuid, 'lock');
            echo "Lock command sent.\n";

        } catch
        (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }

    }


}

<?php

namespace App\Http\Controllers;

use App\Models\TicketImage;
use App\Models\Ticket;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Client;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\ImageManager;
//use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Imagick\Driver;
class TicketController extends Controller
{
    //ロゴ・テキストを配置する縦横の座標値
    const COORDINATES = [
        'logoCenterX' => 0,
        'logoCenterY' => 5,
        'logoLeftX' => 5,
        'logoLeftY' => 0,
        'textCenterX' => 61,
        'textCenterY' => 37,
        'textLeftX' => 77,
        'textLeftY' => 21,
        'textOnlyX' => 61,
        'textOnlyY' => 21,
    ];

    //リサイズするロゴ画像サイズを定義
    const RESIZE_LOGO_SIZE = [
        'widthLeft' => 27,
        'heightLeft' => 27,
        'widthCenter' => 37,
        'heightCenter' => 15,
    ];

    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    }

    // https://image.intervention.io/v3/introduction/upgrade
    public function generateImage(Request $request)
    {
        $manager = new ImageManager(new Driver());
        // 背景画像の呼び出し
        $background = storage_path('app/public/image/default.png');
        $default = $manager->read($background);
        //
        $upload_image = storage_path('app/public/image/bg.png');

        //
        $uploadClientName = "雪霞Shiretoko";

        //保存先のパスを定義
        $save_path = storage_path('app/public/image/image.png');
        // 画像
        $logoImage = $manager->read($upload_image);
        //セットした画像をリサイズする
        $resizedCenter = $logoImage->resize(self::RESIZE_LOGO_SIZE['widthCenter'], self::RESIZE_LOGO_SIZE['heightCenter']);

        //リサイズした画像を白地に合成する
        $vertical = $default->place($resizedCenter, 'top', self::COORDINATES['logoCenterX'], self::COORDINATES['logoCenterY']);
        $vertical->text($uploadClientName, self::COORDINATES['textCenterX'], self::COORDINATES['textCenterY'], function($font) {
            $font->file(storage_path('app/public/font/Boku2-Bold.otf'));
            $font->size(8);
            $font->color('#333333');
            $font->align('center');
            $font->valign('bottom');
        });
        $imageData = $vertical->save($save_path);
        header("Content-Type: image/png");
        echo $imageData;

        return true;
    }

    /**
     *
     * @see https://github.com/SimpleSoftwareIO/simple-qrcode/tree/develop/docs/ja
     * @param string $key
     * @return mixed
     */
    private function __qrGenerate($key = "")
    {
        $uri = "https://nft.ticke.today/in/";
        $png = QrCode::style('square')->format('png')->size(250)->generate($uri.$key);
        $file_name = $key.'_qr.png';
//        header("Content-Type: image/png");
//        $png = base64_encode($png);
//        echo '<img src="data:image/png;base64, '.$png.'">';
        return Storage::put("public/".$file_name, $png);
    }


    public function generateImage3(Request $request)
    {
        $ticket = TicketImage::orderBy('id', 'desc')->first();
        $image = "";
        if(isset($ticket->url)){
            Log::debug(__LINE__ . ': URL:' . print_r($ticket->url, true));
            $image = file_get_contents($ticket->url);
            header("Content-Type: image/png");
            print $image;
        }
        if(isset($ticket->path)){
            $file_name = $ticket->path;
            Log::debug(__LINE__ . ': path:' . print_r($file_name, true));
//          $path_as = Storage::putFileAs('',$image, $file_name);
            Storage::put("public/".$file_name, $image);
            //一時ファイル作成
//            $tmp = tmpfile();
//            //一時ファイルに画像を書き込み
//            fwrite($tmp, $image);
//            //一時ファイルのパスを取得
//            $tmp_path = stream_get_meta_data($tmp)['uri'];
//            //storageに保存。
//            Storage::putFileAs('', new File($tmp_path), $file_name);
//            //一時ファイル削除
//            fclose($tmp);

        }
        Log::debug(__LINE__ . ': ALL:' . print_r($ticket, true));

    }

    public function generateImage2(Request $request)
    {

        $month = sprintf("%d", date("m"));
        $pt = array(
            "アニメ風に描いてください",
            "ゴッホが描いたような絵を描いてください",
            "ピカソが描いたような絵を描いてください",
            "水墨画で描いたような絵を描いてください",
            "プロ写真家が撮ったような画像を出力してください",
            "映画のプロモーションに使われるようなインパクトある面白い写真のように",
            "近未来的なデザインの画像を出力してください",
        );
        $prompt = sprintf("%d月の北海道知床の自然をイメージして", $month);
        $prompt .= $pt[rand(0, count($pt) - 1)];

        $image = OpenAI::images()->create([
//          "model"=> "dall-e-3",
            "model" => "dall-e-2",
            "prompt" => $prompt, // プロンプト
            "n" => 1, // 枚数
            "size" => "256x256",// サイズ
            //  ['256x256', '512x512', '1024x1024', '1024x1792', '1792x1024']
        ]);

        $url = "";
        // 画像のURLを取得する
        $url = $image->data[0]->url;
        Log::debug(__LINE__ . ': URL:' . $url);

        $filename = date("YmdHis");
        $image_path = 'image/' . $filename . '.jpeg';

        $ticket = new TicketImage();
        $ticket->create([
            'path' => $image_path,
            'url' => $url,
            'command' => $prompt,
            'month' => $month,
        ]);
//        $ticket = new Ticket();
//        $ticket->create([
//            'path' => $image_path,
//            'url' => $url,
//            'command' => $prompt,
////          'month' => $month,
//        ]);


//        $jpeg = file_get_contents($url);
        // 画像名を生成する
//        $filename = Str::random(10);
        // 保存する場所を指定する
//        $path = $filename.".jpg";
//        Storage::putFileAs('/var/www/ticketnft/laravel/storage/app/public/image/',$jpeg, $path);

//        $image_path = $filename . '.jpeg';
        // Storage Facadeを使い、ドライバを指定してファイルを保存。ドライバの指定なしだとデフォルトのLOCALドライバが使われる。ストレージドライバはconfig/filesystems.phpの設定による。
//        Storage::disk('public')->put($image_path , $image);
//        Storage::putFile('public', $image, 'public');

//        header("Content-Type: image/jpeg");
//        echo $jpeg;
//        // 古い画像を削除する
//        if ($currentImage = $request->user()->image) {
//            Storage::disk('s3')->delete($currentImage);
//        }
//
//        // URLから取得した画像を指定した$pathに保存する
//        // fopen()はURLを読み込むメソッド
//        $path = Storage::disk('s3')->put($path, fopen($url, 'r'), 'public');
//
//        // s3から画像のパスを取得する
//        $path = Storage::disk('s3')->url($path);
//
//        $request->user()->image = $path;
//        $request->user()->save();
//        return Redirect::route('profile.edit')->with('status', 'プロフィールを更新しました！');
        print "OK";
    }


    private function __getoko()
    {
        $path = storage_path('app/images/smile.png');
        $img = \Image::make($path);


    }


}

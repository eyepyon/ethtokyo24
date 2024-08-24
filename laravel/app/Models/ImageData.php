<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Nette\Utils\Strings;
use PhpParser\Node\Expr\Cast\String_;
use Ramsey\Uuid\Type\Integer;

class ImageData extends Model
{
    use HasFactory;

    protected $table = 'image_datas';

    protected $fillable = [
        'user_id',
        'line_mid',
        'ulid',
        'file_name',
        'file_md5',
        'img_type',
        'model_url',
        'status',
        'advise',
        'complete_flg',
        'human_flg',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    /**
     * id
     * @var integer
     * @OA\Property(
     *  type="integer",
     *  description="ID",
     *  example="1"
     * )
     */
    private $id;

    /**
     * ユーザーid
     * @var integer
     * @OA\Property(
     *  type="integer",
     *  description="User ID",
     *  example=123
     * )
     */
    private $user_id;

    /**
     * Line memberid
     * @var String
     * @OA\Property(
     *  type="String",
     *  description="",
     *  example=
     * )
     */
    private $line_mid;


    /**
     * ulid
     * @var String
     * @OA\Property(
     *  type="String",
     *  description="",
     *  example=
     * )
     */
    private $ulid;

    /**
     *  ファイル名
     * @var String
     * @OA\Property(
     *  type="string",
     *  description="",
     *  example=""
     * )
     */
    private $file_name;

    /**
     * ファイルMD5
     * @var String
     * @OA\Property(
     *  type="string",
     *  description="",
     *  example=""
     * )
     */
    private $file_md5;

    /**
     * 画像タイプ
     * @var integer
     * @OA\Property(
     *  type="integer",
     *  description="",
     *  example=""
     * )
     */
    private $img_type;

    /**
     * モデルURL
     * @var String
     * @OA\Property(
     *  type="string",
     *  description="",
     *  example=""
     * )
     */
    private $model_url;

    /**
     * ステータス
     * @var Integer
     * @OA\Property(
     *  type="int",
     *  description="",
     *  example="0123456"
     * )
     */
    private $status;

    /**
     * アドバイス結果
     * @var String
     * @OA\Property(
     *  type="string",
     *  description="",
     *  example=""
     * )
     */
    private $advisem;

    /**
     * 完了フラグ
     * @var Integer
     * @OA\Property(
     *  type="int",
     *  description="",
     *  example="0123456"
     * )
     */
    private $complete_flg;

    /**
     * 人間判定フラグ
     * @var Integer
     * @OA\Property(
     *  type="int",
     *  description="",
     *  example=""
     * )
     */
    private $human_flg;


}

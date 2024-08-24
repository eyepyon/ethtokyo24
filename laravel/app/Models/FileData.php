<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Nette\Utils\Strings;
use PhpParser\Node\Expr\Cast\String_;
use Ramsey\Uuid\Type\Integer;

class FileData extends Model
{
    use HasFactory;

    protected $table = 'file_datas';

    protected $fillable = [
        'user_id',
        'line_mid',
        'ulid',
        'file_name',
        'file_md5',
        'file_type',
        'complete_flg',
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
     *
     * @var String
     * @OA\Property(
     *  type="string",
     *  description="",
     *  example=""
     * )
     */
    private $file_name;

    /**
     *
     * @var String
     * @OA\Property(
     *  type="string",
     *  description="",
     *  example=""
     * )
     */
    private $file_md5;

    /**
     *
     * @var integer
     * @OA\Property(
     *  type="integer",
     *  description="",
     *  example=""
     * )
     */
    private $file_type;

    /**
     *
     * @var Integer
     * @OA\Property(
     *  type="int",
     *  description="",
     *  example="0123456"
     * )
     */
    private $complete_flg;


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Nette\Utils\Strings;
use PhpParser\Node\Expr\Cast\String_;
use Ramsey\Uuid\Type\Integer;

class Bonus extends Model
{
    use HasFactory;

    protected $table = 'bonuses';

    protected $fillable = [
        'user_id',
        'line_mid',
        'type',
        'counter',
        'xym',
        'status',
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
     * xym
     * @var integer
     * @OA\Property(
     *  type="Integer",
     *  description="",
     *  example=
     * )
     */
    private $type;

    /**
     * xym
     * @var integer
     * @OA\Property(
     *  type="Integer",
     *  description="",
     *  example=
     * )
     */
    private $counter;

    /**
     * xym
     * @var integer
     * @OA\Property(
     *  type="Integer",
     *  description="",
     *  example=
     * )
     */
    private $xym;

    /**
     *
     * @var integer
     * @OA\Property(
     *  type="integer",
     *  description="",
     *  example=""
     * )
     */
    private $status;



}

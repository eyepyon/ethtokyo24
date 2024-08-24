<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Str;
//use Nette\Utils\Strings;
//use Ramsey\Uuid\Type\Integer;
class TicketImage extends Model
{
    use HasFactory;

    protected $table = 'ticket_images';

    protected $fillable = [
        'path',
        'url',
        'command',
        'month',
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
     * path
     * @var String
     * @OA\Property(
     *  type="String",
     *  description="",
     *  example=
     * )
     */
    private $path;

    /**
     * url
     * @var String
     * @OA\Property(
     *  type="String",
     *  description="",
     *  example=
     * )
     */
    private $url;

    /**
     *  command
     * @var String
     * @OA\Property(
     *  type="string",
     *  description="",
     *  example=""
     * )
     */
    private $command;

    /**
     * month
     * @var integer
     * @OA\Property(
     *  type="integer",
     *  description="",
     *  example=""
     * )
     */
    private $month;

//    /**
//     * ステータス
//     * @var Integer
//     * @OA\Property(
//     *  type="int",
//     *  description="",
//     *  example="0123456"
//     * )
//     */
//    private $status;

}

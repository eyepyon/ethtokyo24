<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Nette\Utils\Strings;
use PhpParser\Node\Expr\Cast\String_;
use Ramsey\Uuid\Type\Integer;

class Door extends Model
{
    use HasFactory;

    protected $table = 'doors';

    protected $fillable = [
        'id',
        'name',
        'device_uuid',
        'device_secret',
    ];

    protected $hidden = [
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
     * name
     * @var String
     * @OA\Property(
     *  type="String",
     *  description="",
     *  example=
     * )
     */
    private $name;


    /**
     * device_uuid
     * @var String
     * @OA\Property(
     *  type="String",
     *  description="",
     *  example=
     * )
     */
    private $device_uuid;

    /**
     *
     * @var String
     * @OA\Property(
     *  type="string",
     *  description="",
     *  example=""
     * )
     */
    private $device_secret;


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     required={},
 *     @OA\Property(property="id", type="integer", format="int64", example=1, readOnly=true),
 *     @OA\Property(property="name", type="string", example="Ivan Ivanov"),
 *     @OA\Property(property="email", type="string", format="email", example="email@email.com"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2022-01-02 12:13:14",
 *     readOnly=true),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2022-01-02 12:13:14",
 *     readOnly=true)
 * )
 *
 * @OA\Schema(
 *     schema="Users",
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(type="object", ref="#/components/schemas/User"),
 *     )
 * )
 *
 * @OA\Parameter(
 *      parameter="User--id",
 *      in="path",
 *      name="user_id",
 *      required=true,
 *      description="Id of User",
 *      example=1,
 *      @OA\Schema(
 *          type="integer",
 *      )
 * )
 */
class User extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function unFinishedTrips() {
        return $this->hasMany(Trip::class)->whereNull('finish_at');
    }

    public function trips() {
        return $this->hasMany(Trip::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Trip",
 *     type="object",
 *     required={},
 *     @OA\Property(property="id", type="integer", format="int64",example=1, readOnly=true),
 *     @OA\Property(property="comment", type="string", example="Grocery shopping trip"),
 *     @OA\Property(property="user_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="vehicle_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="start_at", type="string", format="datetime", example="2022-01-02 12:13:14",
 *     readOnly=true),
 *     @OA\Property(property="finish_at", type="string", format="datetime", example="2022-01-02 13:00:00",
 *     readOnly=true, nullable=true),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2022-01-02 12:13:14",
 *     readOnly=true),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2022-01-02 12:13:14",
 *     readOnly=true)
 * )
 *
 * @OA\Schema(
 *     schema="Trips",
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(type="object", ref="#/components/schemas/Trip"),
 *     )
 * )
 *
 * @OA\Parameter(
 *      parameter="Trip--id",
 *      in="path",
 *      name="trip_id",
 *      required=true,
 *      description="Id of Trip",
 *      example=1,
 *      @OA\Schema(
 *          type="integer",
 *      )
 * )
 */
class Trip extends Model {
    use HasFactory;

    protected $fillable = [
        'comment',
        'user_id',
        'vehicle_id',
        'start_at',
        'finish_at',
    ];
    protected $casts = [
        'start_at'   => 'datetime:Y-m-d H:i:s',
        'finish_at'  => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function user() {
        return $this->belongsTo(Trip::class);
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }
}

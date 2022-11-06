<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Vehicle",
 *     type="object",
 *     required={},
 *     @OA\Property(property="id", type="integer", format="int64", example=1, readOnly=true),
 *     @OA\Property(property="model", type="string", example="Volvo"),
 *     @OA\Property(property="number", type="string", example="ABC-123"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2022-01-02 12:13:14",
 *     readOnly=true),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2022-01-02 12:13:14",
 *     readOnly=true)
 * )
 *
 * @OA\Schema(
 *     schema="Vehicles",
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(type="object", ref="#/components/schemas/Vehicle"),
 *     )
 * )
 *
 * @OA\Parameter(
 *      parameter="Vehicle--id",
 *      in="path",
 *      name="vehicle_id",
 *      required=true,
 *      description="Id of Vehicle",
 *      example=1,
 *      @OA\Schema(
 *          type="integer",
 *      )
 * )
 */
class Vehicle extends Model {
    use HasFactory;

    protected $fillable = [
        'model',
        'number',
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

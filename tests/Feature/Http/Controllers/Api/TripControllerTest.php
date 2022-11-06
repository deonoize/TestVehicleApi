<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Trip;
use Tests\ApiControllerTest;
use Tests\Traits\ApiIndexControllerTest;
use Tests\Traits\ApiShowControllerTest;

class TripControllerTest extends ApiControllerTest {
    use ApiIndexControllerTest,
        ApiShowControllerTest;

    public function getModel(): string {
        return Trip::class;
    }

    public function getRoute(): string {
        return 'trips';
    }

    public function getJsonStructureForIndex(): array {
        return [
            'data' => [
                '*' => [
                    'id',
                    'comment',
                    'user_id',
                    'vehicle_id',
                    'start_at',
                    'finish_at',
                    'created_at',
                    'updated_at',
                ],
            ],
        ];
    }

    public function getJsonForShow($entity): array {
        return [
            'id'         => $entity->id,
            'comment'    => $entity->comment,
            'user_id'    => $entity->user_id,
            'vehicle_id' => $entity->vehicle_id,
            'start_at'   => (string) $entity->start_at,
            'finish_at'  => (string) $entity->finish_at,
            'created_at' => (string) $entity->created_at,
            'updated_at' => (string) $entity->updated_at,
        ];
    }
}

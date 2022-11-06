<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Vehicle;
use Tests\ApiControllerTest;
use Tests\Traits\ApiDestroyControllerTest;
use Tests\Traits\ApiIndexControllerTest;
use Tests\Traits\ApiShowControllerTest;
use Tests\Traits\ApiStoreControllerTest;
use Tests\Traits\ApiUpdateControllerTest;

class VehicleControllerTest extends ApiControllerTest {
    use ApiIndexControllerTest,
        ApiShowControllerTest,
        ApiStoreControllerTest,
        ApiUpdateControllerTest,
        ApiDestroyControllerTest;

    public function getModel(): string {
        return Vehicle::class;
    }

    public function getRoute(): string {
        return 'vehicles';
    }

    public function getJsonStructureForIndex(): array {
        return [
            'data' => [
                '*' => [
                    'id',
                    'model',
                    'number',
                    'created_at',
                    'updated_at',
                ],
            ],
        ];
    }

    public function getJsonStructureForStore(): array {
        return [
            'data' => [
                'id',
                'model',
                'number',
                'created_at',
                'updated_at',
            ],
        ];
    }

    public function getJsonForShow($entity): array {
        return [
            'id'         => $entity->id,
            'model'      => $entity->model,
            'number'     => $entity->number,
            'created_at' => (string) $entity->created_at,
            'updated_at' => (string) $entity->updated_at,
        ];
    }

    public function getJsonForUpdate($entity, $payload): array {
        return [
            'id'         => $entity->id,
            'model'      => $payload['model'],
            'number'     => $payload['number'],
            'created_at' => (string) $entity->created_at,
            'updated_at' => (string) $entity->refresh()->updated_at,
        ];
    }

    public function changeForMissingData(&$payload): void {
        unset($payload['number']);
    }
}

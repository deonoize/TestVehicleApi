<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Trip;
use App\Models\User;
use Tests\ApiControllerTest;
use Tests\Traits\ApiIndexControllerTest;
use Tests\Traits\ApiShowControllerTest;

class UserTripControllerTest extends ApiControllerTest {
    use ApiIndexControllerTest,
        ApiShowControllerTest;

    public function getModel(): string {
        return Trip::class;
    }

    public function getRoute(): string {
        return 'users.trips';
    }

    public function getRouteForIndex(): string {
        $user = User::factory()->create();
        Trip::factory(2)->for($user)->create();
        return route($this->getRoute().'.index', [$user->id]);
    }

    public function getRouteForShow($entity): string {
        return route($this->getRoute().'.show', [$entity->user_id, $entity->id]);
    }

    public function getRouteForShowMissing(): string {
        $user = User::factory()->create();
        return route($this->getRoute().'.show', [$user->id, 0]);
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

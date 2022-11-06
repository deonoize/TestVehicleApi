<?php

namespace Tests\Traits;

trait ApiUpdateControllerTest {
    abstract public function getJsonForUpdate($entity, $payload): array;

    public function getRouteForUpdate($entity): string {
        return route($this->getRoute().'.update', [$entity->id]);
    }

    public function getRouteForUpdateMissing(): string {
        return route($this->getRoute().'.update', [0]);
    }

    public function testUpdateEntityReturnsCorrectData(): void {
        $entity = ($this->getModel())::factory()->create();
        $payload = ($this->getModel())::factory()->make()->getAttributes();
        $this->json('put', $this->getRouteForUpdate($entity), $payload)
             ->assertOk()
             ->assertExactJson(
                 [
                     'data' => $this->getJsonForUpdate($entity, $payload),
                 ]
             );
    }

    public function testUpdateForMissingEntity(): void {
        $payload = ($this->getModel())::factory()->make()->getAttributes();
        $this->json('put', $this->getRouteForUpdateMissing(), $payload)
             ->assertNotFound()
             ->assertJsonStructure(['message']);
    }
}

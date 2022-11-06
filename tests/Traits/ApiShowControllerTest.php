<?php

namespace Tests\Traits;

trait ApiShowControllerTest {
    abstract public function getJsonForShow($entity): array;

    public function getRouteForShow($entity): string {
        return route($this->getRoute().'.show', [$entity->id]);
    }

    public function getRouteForShowMissing(): string {
        return route($this->getRoute().'.show', [0]);
    }

    public function testEntityIsShownCorrectly(): void {
        $entity = ($this->getModel())::factory()->create();
        $this->json('get', $this->getRouteForShow($entity))
             ->assertOk()
             ->assertExactJson(
                 [
                     'data' => $this->getJsonForShow($entity),
                 ]
             );
    }

    public function testShowForMissingEntity(): void {
        $this->json('get', $this->getRouteForShowMissing())
             ->assertNotFound()
             ->assertJsonStructure(['message']);
    }
}

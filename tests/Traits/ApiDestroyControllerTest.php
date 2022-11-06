<?php

namespace Tests\Traits;

trait ApiDestroyControllerTest {
    public function getRouteForDestroy($entity): string {
        return route($this->getRoute().'.destroy', [$entity->id]);
    }

    public function getRouteForDestroyMissing(): string {
        return route($this->getRoute().'.destroy', [0]);
    }

    public function testEntityIsDestroyed(): void {
        $data = ($this->getModel())::factory()->make()->getAttributes();
        $entity = ($this->getModel())::create($data);
        $this->json('delete', $this->getRouteForDestroy($entity))
             ->assertNoContent();
        $this->assertDatabaseMissing($this->getTable($this->getModel()), $data);
    }

    public function testDestroyForMissingEntity(): void {
        $this->json('delete', $this->getRouteForDestroyMissing())
             ->assertNotFound()
             ->assertJsonStructure(['message']);
    }
}

<?php

namespace Tests\Traits;

trait ApiStoreControllerTest {
    abstract public function getJsonStructureForStore(): array;

    public function getRouteForStore(): string {
        return route($this->getRoute().'.store');
    }

    public function testEntityIsStoredSuccessfully(): void {
        $payload = ($this->getModel())::factory()->make()->getAttributes();
        $this->json('post', $this->getRouteForStore(), $payload)
             ->assertCreated()
             ->assertJsonStructure(
                 $this->getJsonStructureForStore()
             );
        $this->assertDatabaseHas($this->getTable($this->getModel()), $payload);
    }

    public function testStoreWithMissingData(): void {
        $payload = ($this->getModel())::factory()->make()->getAttributes();
        $this->changeForMissingData($payload);
        $this->json('post', $this->getRouteForStore(), $payload)
             ->assertUnprocessable()
             ->assertJsonStructure(['message', 'errors' => ['*' => []]]);
    }
}

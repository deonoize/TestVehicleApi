<?php

namespace Tests\Traits;

trait ApiIndexControllerTest {
    abstract public function getJsonStructureForIndex(): array;

    public function getRouteForIndex(): string {
        ($this->getModel())::factory(2)->create();
        return route($this->getRoute().'.index');
    }

    public function testIndexReturnsDataInValidFormat(): void {
        $this->json('get', $this->getRouteForIndex())
             ->assertOk()
             ->assertJsonStructure(
                 $this->getJsonStructureForIndex()
             );
    }
}

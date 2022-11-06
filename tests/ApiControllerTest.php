<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class ApiControllerTest extends TestCase {
    use DatabaseTransactions;

    abstract public function getModel(): string;

    abstract public function getRoute(): string;

    public function setUp(): void {
        parent::setUp();

        $this->route = $this->getRoute();
    }
}

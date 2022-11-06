<?php

namespace Http\Controllers\Api;

use App\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase {
    public function testIndexReturnsDataInValidFormat() {
        User::factory(2)->create();
        $this->json('get', 'api/users')
             ->assertOk()
             ->assertJsonStructure(
                 [
                     'data' => [
                         '*' => [
                             'id',
                             'name',
                             'email',
                             'created_at',
                             'updated_at',
                         ],
                     ],
                 ]
             );
    }

    public function testUserIsCreatedSuccessfully() {
        $payload = User::factory()->make()->getAttributes();
        $this->json('post', 'api/users', $payload)
             ->assertCreated()
             ->assertJsonStructure(
                 [
                     'data' => [
                         'id',
                         'name',
                         'email',
                         'created_at',
                         'updated_at',
                     ],
                 ]
             );
        $this->assertDatabaseHas('users', $payload);
    }

    public function testUserIsShownCorrectly() {
        $user = User::factory()->create();
        $this->json('get', "api/users/$user->id")
             ->assertOk()
             ->assertExactJson(
                 [
                     'data' => [
                         'id'         => $user->id,
                         'name'       => $user->name,
                         'email'      => $user->email,
                         'created_at' => (string) $user->created_at,
                         'updated_at' => (string) $user->updated_at,
                     ],
                 ]
             );
    }

    public function testUserIsDestroyed() {
        $data = User::factory()->make()->getAttributes();
        $user = User::create($data);
        $this->json('delete', "api/users/$user->id")
             ->assertNoContent();
        $this->assertDatabaseMissing('users', $data);
    }

    public function testUpdateUserReturnsCorrectData() {
        $user = User::factory()->create();
        $payload = User::factory()->make()->getAttributes();
        $this->json('put', "api/users/$user->id", $payload)
             ->assertOk()
             ->assertExactJson(
                 [
                     'data' => [
                         'id'         => $user->id,
                         'name'       => $payload['name'],
                         'email'      => $payload['email'],
                         'created_at' => (string) $user->created_at,
                         'updated_at' => (string) $user->refresh()->updated_at,
                     ],
                 ]
             );
    }

    public function testShowForMissingUser() {
        $this->json('get', "api/users/0")
             ->assertNotFound()
             ->assertJsonStructure(['message']);
    }

    public function testUpdateForMissingUser() {
        $payload = User::factory()->make()->getAttributes();
        $this->json('put', 'api/users/0', $payload)
             ->assertNotFound()
             ->assertJsonStructure(['message']);
    }

    public function testDestroyForMissingUser() {
        $this->json('delete', 'api/users/0')
             ->assertNotFound()
             ->assertJsonStructure(['message']);
    }

    public function testStoreWithMissingData() {
        $payload = User::factory()->make()->getAttributes();
        unset($payload['email']);
        $this->json('post', 'api/users', $payload)
             ->assertUnprocessable()
             ->assertJsonStructure(['message', 'errors' => ['*' => []]]);
    }
}

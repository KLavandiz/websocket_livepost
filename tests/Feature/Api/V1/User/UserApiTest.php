<?php

namespace Api\V1\User;

use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserDeleted;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        Event::fake();
        $user = User::factory(10)->create();

        $userIds = $user->pluck('name')->toArray();

        $response = $this->get('api/v1/users');

        Event::assertDispatched(UserCreated::class);

        $response->assertStatus(200);

        $data = $response->json('data');

        collect($data)->each(fn($userData) => $this->assertTrue(in_array($userData['name'], $userIds)));

    }

    public function test_show()
    {

        $user = User::factory()->create();

        $response = $this->json('get', 'api/v1/users/' . $user->id);


        $result = $response->assertStatus(200)->json('data');

        $this->assertEquals(data_get($result, 'id'), $user->id);

    }

    public function test_create()
    {

        $dummyUser = User::factory()->make();

        $response = $this->json('post', 'api/v1/users', $dummyUser->toArray());

        $result = $response->assertStatus(201)->json('data');


        array_walk_recursive($result, function ($value, $field) use ($dummyUser, $result) {
            $this->assertSame(data_get($result, $value), $dummyUser->$value, 'Failed to create user model');
        });

    }

    public function test_update()
    {
        $user = User::factory()->create();
        $dummyUser = User::factory()->make();

        $response = $this->json('patch', 'api/v1/users/' . $user->id, $dummyUser->toArray());

        $result = $response->assertStatus(200)->json('data');

        $fillables = $dummyUser->getFillable();

        array_walk_recursive($fillables, function ($value, $field) use ($dummyUser, $result) {
            if (!$value == 'password') {
                $this->assertEquals(data_get($result, $value), $dummyUser->$value, 'Failed to update user model');
            }
        });

    }

    public function test_delete()
    {
        $user = User::factory()->create();

        $response = $this->json('delete', 'api/v1/users/' . $user->id);

        $response->assertStatus(200);
        $this->expectException(ModelNotFoundException::class);

        User::query()->findOrFail($user->id);

    }


}

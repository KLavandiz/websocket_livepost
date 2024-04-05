<?php

namespace Tests\Unit;

use App\Exceptions\NormalException;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;
    public function test_create()
    {
        $repositroy = $this->app->make(UserRepository::class);
        $randomNumber = rand(123, 44432234);
        $dummyUser = [
            'name' => 'Test User',
            'email' => $randomNumber . 'admin@admin.com',
            'password' => Hash::make('admin'),
        ];

        $created = $repositroy->create($dummyUser);

        $this->assertSame($dummyUser['name'], $created->name, 'Creating user does not working');
    }

    public function test_update()
    {
        $repositroy = $this->app->make(UserRepository::class);

        $user = User::factory(1)->create()->first();
        $randomNumber = rand(123, 44432234);
        $dummyUser = [
            'name' => 'Test User',
            'email' => $randomNumber . 'demo@demo.com',
            'password' => Hash::make('admin'),
        ];

        $created = $repositroy->update($user, $dummyUser);

        $this->assertSame($dummyUser['name'], $created->name, 'Creating user does not working');
    }

    public function test_throw_error_delete_user_that_doesnt_exist()
    {
        $repository = $this->app->make(UserRepository::class);

        $user = User::factory(1)->make()->first();

        $this->expectException(NormalException::class);

        $deleted = $repository->forceDelete($user);

    }

    public function test_delete()
    {
        $repository = $this->app->make(UserRepository::class);

        $user = User::factory(1)->create()->first();

        $deleted = $repository->forceDelete($user);

        $found = User::query()->find($deleted->id);

        $this->assertSame(null, $found, 'User not deleted');
    }
}

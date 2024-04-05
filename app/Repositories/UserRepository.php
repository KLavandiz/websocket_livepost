<?php

namespace App\Repositories;

use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserDeleted;
use App\Events\Models\User\UserUpdated;
use App\Helpers\Exception\GeneralException;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $created = User::query()->create([
                'name' => data_get($attributes, 'name'),
                'email' => data_get($attributes, 'email'),
                'password' => Hash::make(data_get($attributes, 'password')),
            ]);

            GeneralException::throw(!$created, 'Unable to create user');

            // event(new UserCreated($created)); // send an email to the client

            return $created;
        });
    }

    public function update(User $user, array $attributes)
    {
        return DB::transaction(function () use ($user, $attributes) {
            $updated = $user->update([
                'name' => data_get($attributes, 'name', $user->name),
                'email' => data_get($attributes, 'email', $user->email),
                'password' => Hash::make(data_get($attributes, 'password'))
            ]);

            GeneralException::throw(!$updated, 'Unable to update user');

            // event(new UserUpdated($user));

            return $user;
        });
    }

    public function forceDelete(User $user)
    {
        $deleted = $user->forceDelete();

        GeneralException::throw(!$deleted, 'Unable to delete user');
        //event(new UserDeleted($user));
        return $user;
    }
}

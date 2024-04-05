<?php

namespace App\Interfaces;

use App\Models\User;

interface UserInterface
{
    public function create(array $attributes);

    public function update(User $user, array $attributes);

    public function forceDelete(User $user);
}

<?php

use App\Helpers\Routes\UserRoutes;
use App\Http\Controllers\UserController;

UserRoutes::name('users.')
    ->namespace('App\Http\Controllers')
    ->group(function () {

        UserRoutes::get('/users', [UserController::class, 'index'])->name('index')->withoutMiddleware('auth');//exclude from auth middleware

        UserRoutes::get('users/{user}', [UserController::class, 'show'])->name('show')->where('user', '[0-9]+'); //{user} can be only numbers

        UserRoutes::post('/users', [UserController::class, 'store'])->name('store');

        UserRoutes::patch('users/{user}', [UserController::class, 'update'])->name('patch')->whereNumber('user'); //only numbers for {user}

        UserRoutes::delete('users/{user}', [UserController::class, 'destroy'])->name('delete');

    });


<?php


use App\Helpers\Routes\PostRoutes;
use App\Http\Controllers\PostController;

PostRoutes::name('posts.')
    ->namespace('App\Http\Controllers')
    ->group(function () {

        PostRoutes::get('/posts', [PostController::class, 'index'])->name('index')->withoutMiddleware('auth');//exclude from auth middleware

        PostRoutes::get('posts/{post}', [PostController::class, 'show'])->name('show')->where('post', '[0-9]+'); //{user} can be only numbers

        PostRoutes::post('/posts', [PostController::class, 'store'])->name('store');

        PostRoutes::patch('posts/{post}', [PostController::class, 'update'])->name('patch')->whereNumber('post'); //only numbers for {user}

        PostRoutes::delete('posts/{post}', [PostController::class, 'destroy'])->name('delete');

    });

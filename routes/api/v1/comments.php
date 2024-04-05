<?php

use App\Helpers\Routes\CommentRoutes;
use App\Http\Controllers\CommentController;

CommentRoutes::name('comments.')
    ->namespace('App\Http\Controllers')
    ->group(function () {

        CommentRoutes::get('/comments', [CommentController::class, 'index'])->name('index')->withoutMiddleware('auth');//exclude from auth middleware

        CommentRoutes::get('comments/{comment}', [CommentController::class, 'show'])->name('show')->where('comment', '[0-9]+'); //{user} can be only numbers

        CommentRoutes::post('/comments', [CommentController::class, 'store'])->name('store');

        CommentRoutes::patch('comments/{comment}', [CommentController::class, 'update'])->name('patch')->whereNumber('comment'); //only numbers for {user}

        CommentRoutes::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('delete');

    });

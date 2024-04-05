<?php

namespace App\Subscribers\Models;

use App\Events\Models\Comment\CommentCreated;
use App\Events\Models\Comment\CommentDeleted;
use App\Events\Models\Comment\CommentUpdated;
use App\Listeners\WelcomeEmail;
use Illuminate\Events\Dispatcher;

class CommentSubscriber
{
    public function subscribe(Dispatcher $event)
    {
        $event->listen(CommentCreated::class, WelcomeEmail::class);
        $event->listen(CommentUpdated::class, WelcomeEmail::class);
        $event->listen(CommentDeleted::class, WelcomeEmail::class);

    }

}

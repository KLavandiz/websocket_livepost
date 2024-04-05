<?php

namespace App\Subscribers\Models;

use App\Events\Models\Post\PostCreated;
use App\Events\Models\Post\PostDeleted;
use App\Events\Models\Post\PostUpdated;
use App\Listeners\WelcomeEmail;
use Illuminate\Events\Dispatcher;

class PostSubsriber
{
    public function subscribe(Dispatcher $event)
    {
        $event->listen(PostCreated::class, WelcomeEmail::class);
        $event->listen(PostUpdated::class, WelcomeEmail::class);
        $event->listen(PostDeleted::class, WelcomeEmail::class);

    }
}

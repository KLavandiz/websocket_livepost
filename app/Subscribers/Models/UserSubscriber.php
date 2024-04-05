<?php

namespace App\Subscribers\Models;

use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserDeleted;
use App\Events\Models\User\UserUpdated;
use App\Listeners\WelcomeEmail;
use Illuminate\Events\Dispatcher;

class UserSubscriber
{
    public function subscribe(Dispatcher $event)
    {
        $event->listen(UserCreated::class, WelcomeEmail::class);
        $event->listen(UserUpdated::class, WelcomeEmail::class); //example purpose
        $event->listen(UserDeleted::class, WelcomeEmail::class);//example purpose

    }

}

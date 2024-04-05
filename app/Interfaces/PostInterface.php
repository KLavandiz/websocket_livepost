<?php

namespace App\Interfaces;

use App\Models\Post;

interface PostInterface
{
    public function create(array $attributes);

    public function update(Post $post, array $attributes);

    public function forceDelete(Post $post);

}

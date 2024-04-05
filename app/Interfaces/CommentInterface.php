<?php

namespace App\Interfaces;

use App\Models\Comment;

interface CommentInterface
{
    public function create(array $attributes);

    public function update(Comment $comment, array $attributes);

    public function forceDelete(Comment $comment);
}

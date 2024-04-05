<?php

namespace App\Repositories;

use App\Events\Models\Comment\CommentCreated;
use App\Events\Models\Comment\CommentDeleted;
use App\Events\Models\Comment\CommentUpdated;
use App\Helpers\Exception\GeneralException;
use App\Interfaces\CommentInterface;
use App\Interfaces\UserInterface;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CommentRepository implements CommentInterface
{

    public function create(array $attributes)
    {
        $created = Comment::query()->create([
            'body' => data_get($attributes, 'body'),
            'user_id' => data_get($attributes, 'user_id'),
            'post_id' => data_get($attributes, 'post_id'),
        ]);


        GeneralException::throw(!$created, 'Unable to create comment');

        //throw_if(!$created, GeneralException::class, 'Unable to update comment');

        event(new CommentCreated($created));


        return $created;
    }

    public function update(Comment $comment, array $attributes)
    {
        return DB::transaction(function () use ($comment, $attributes) {
            $updated = $comment->update([
                'body' => data_get($attributes, 'body', $comment->body),
                'user_id' => data_get($attributes, 'user_id', $comment->user_id),
                'post_id' => data_get($attributes, 'post_id', $comment->post_id),
            ]);


            GeneralException::throw(!$updated, 'Unable to update comment');

            //   throw_if(!$updated, GeneralException::class, 'Unable to update comment');

            event(new CommentUpdated($comment));

            return $comment;
        });
    }

    public function forceDelete(Comment $comment)
    {
        $deleted = $comment->forceDelete();

        GeneralException::throw(!$deleted, 'Unable to create comment');
        //throw_if(!$deleted, GeneralException::class, 'Unable to delete comment');
        event(new CommentDeleted($comment));

        return $comment;
    }
}

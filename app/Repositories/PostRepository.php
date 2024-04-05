<?php

namespace App\Repositories;

use App\Events\Models\Post\PostCreated;
use App\Events\Models\Post\PostDeleted;
use App\Events\Models\Post\PostUpdated;
use App\Helpers\Exception\GeneralException;
use App\Interfaces\PostInterface;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostInterface
{

    public function create(array $attributes)
    {
        $post = DB::transaction(function () use ($attributes) {

            $post = Post::query()->create([
                'title' => data_get($attributes, 'title', 'Untitled'),
                'body' => data_get($attributes, 'body'),
            ]);

            GeneralException::throw(!$post, 'Unable to create post');

            if ($userIds = data_get($attributes, 'userIds')) {
                $post->users()->sync($userIds);
            }

            event(new PostCreated($post)); //trigger the event


            return $post;

        });

        return $post;
    }

    public function update(Post $post, array $attributes)
    {
        return DB::transaction(function () use ($attributes, $post) {
            $updated = $post->update([
                'title' => data_get($attributes, 'title', 'Untitled'),
                'body' => data_get($attributes, 'body'),
            ]);

            if ($userIds = data_get($attributes, 'user_ids')) {
                $post->users()->sync($userIds);
            }

            GeneralException::throw(!$updated, 'Unable to update post');

             event(new PostUpdated($post));

            return $post;
        });
    }

    public function forceDelete(Post $post)
    {
        return DB::transaction(function () use ($post) {
            $deleted = $post->forceDelete();

            GeneralException::throw(!$deleted, 'Unable to delete post');

             event(new PostDeleted($post));

            return $post;
        });
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\User;
use App\Notifications\PostSharedNotification;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

/**
 * @group Post Management
 * APIs to manage post resource.
 */
class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $pageSize = $request->page_size ?? 20;
        $post = Post::query()->paginate($pageSize);
        return PostResource::collection($post);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request, PostRepository $postRepository): PostResource
    {


        $created = $postRepository->create($request->only([
            'title',
            'body',
            'userIds'
        ]));

        $user = User::query()->find(13);
        Notification::send($user, new PostSharedNotification($created,''));

        return new PostResource($created);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): PostResource
    {

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, PostRepository $postRepository): PostResource|JsonResponse
    {
        $updated = $postRepository->update($post, $request->only(['title', 'body', 'user_ids']));
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, PostRepository $postRepository): JsonResponse|PostResource
    {
        $deleted = $postRepository->forceDelete($post);

        return new PostResource($post);
    }
}

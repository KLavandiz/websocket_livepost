<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Repositories\CommentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @group Comment Management
 * APIs to manage comment resource.
 */
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $pageSize = $request->page_size ?? 20;
        $comment = Comment::query()->paginate($pageSize);
        return CommentResource::collection($comment);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentStoreRequest $request, CommentRepository $commentRepository): JsonResponse|CommentResource
    {
        $created = $commentRepository->create($request->only(['body', 'user_id', 'post_id']));

        return new CommentResource($created);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment): CommentResource
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment, CommentRepository $commentRepository): JsonResponse|CommentResource
    {

        $updated = $commentRepository->update($comment, $request->only(['body', 'user_id', 'post_id']));

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment, CommentRepository $commentRepository): JsonResponse|CommentResource
    {
        $deleted = $commentRepository->forceDelete($comment);
        return new CommentResource($comment);
    }
}

<?php

namespace App\Http\Controllers;

use App\Events\Models\User\UserCreated;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @group User Management
 * APIs to manage user resource.
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @queryParam page_size int required Size per page 20.
     * @queryParam page int Page to view.
     */
    public function index(): JsonResponse|ResourceCollection
    {
        $users = User::query()->get();
        event(new UserCreated(User::factory()->make()));
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request, UserRepository $userRepository): JsonResponse|UserResource
    {

        $created = $userRepository->create($request->only([
            'name',
            'email',
            'password'
        ]));

        return new UserResource($created);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user, UserRepository $userRepository): UserResource
    {
        $updated = $userRepository->update($user, $request->only(['name', 'email', 'password']));
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, UserRepository $userRepository): JsonResponse
    {
        $deleted = $userRepository->forceDelete($user);
        return response()->json(['data' => 'success']);
    }
}

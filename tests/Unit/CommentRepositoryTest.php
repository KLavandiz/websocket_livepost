<?php

namespace Tests\Unit;

use App\Events\Models\Comment\CommentCreated;
use App\Events\Models\Comment\CommentDeleted;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CommentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create()
    {

        $expectedEvent = Event::fake();

        $repository = $this->app->make(CommentRepository::class);

        $dummyComment = Comment::factory(1)->make()->first();

        $created = $repository->create($dummyComment->toArray());

        $expectedEvent->assertDispatched(CommentCreated::class); // to check that Event triggered!

        $this->assertSame($created->body, $dummyComment->body, 'Creating comment not working');

    }

    public function test_update()
    {

        $repo = $this->app->make(CommentRepository::class);

        $dummyComm = Comment::factory(1)->create()->first();


        $payLoad = [
            'body' => ['demo'],
            'post_id' => $dummyComm->post_id,
            'user_id' => $dummyComm->user_id,
        ];

        $updated = $repo->update($dummyComm, $payLoad);

        $this->assertSame($updated->body, $payLoad['body'], 'Unable to update comment');

    }

    public function test_delete()
    {
        $eventcheck = Event::fake();
        $repository = $this->app->make(CommentRepository::class);

        $dummyComment = Comment::factory(1)->create()->first();


        $deleted = $repository->forceDelete($dummyComment);

        $eventcheck->assertDispatched(CommentDeleted::class);

        $record = Comment::query()->find($deleted->id);

        $this->assertSame(null, $record, 'Unable to deletede comment');
    }
}

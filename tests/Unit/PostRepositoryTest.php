<?php

namespace Tests\Unit;


use App\Exceptions\NormalException;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create()
    {

        $repository = $this->app->make(PostRepository::class); //instance of PostRepository

        $payload = [
            'title' => 'heyaa',
            'body' => [],
        ];

        $result = $repository->create($payload);

        $this->assertSame($payload['title'], $result->title, 'Post Create title is not same');
    }

    public function test_update()
    {
        $repository = $this->app->make(PostRepository::class);//instance of PostRepository

        $dummyPost = Post::factory(1)->create()[0];

        $payload = [
            'title' => 'abc123',
        ];

        $updated = $repository->update($dummyPost, $payload);

        $this->assertSame($payload['title'], $updated->title, 'Post update does not have same title value');
    }

    public function test_delete_will_throw_exception_when_delete_post_that_doesnt_exists()
    {
        $repository = $this->app->make(PostRepository::class);//instance of PostRepository

        $dummy = Post::factory(1)->make()->first(); // make() dummy data

        $this->expectException(NormalException::class);

        $deleted = $repository->forceDelete($dummy);

    }

    public function test_delete()
    {
        $repository = $this->app->make(PostRepository::class);

        $dummy = Post::factory(1)->create()->first();

        $deleted = $repository->forceDelete($dummy);

        $found = Post::query()->find($dummy->id);

        $this->assertSame(null, $found, 'Post is not deleted');

    }
}

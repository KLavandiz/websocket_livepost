<?php

namespace Api\V1\Post;

use App\Events\Models\Post\PostCreated;
use App\Events\Models\Post\PostDeleted;
use App\Events\Models\Post\PostUpdated;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        //load data in DB
        $posts = Post::factory(10)->create();

        $postIds = $posts->pluck('id')->toArray();

        // $postIds = $posts->map(fn($post) => $post->id)->toArray();

        // dump($postIds);
        // call index endpoint
        $response = $this->json('get', 'api/v1/posts');


        // assert status
        $response->assertStatus(200);

        // verify records
        $data = $response->json('data');

        collect($data)->each(fn($post) => $this->assertTrue(in_array($post['id'], $postIds)));

    }

    public function test_show()
    {
        $post = Post::factory()->create();

        $response = $this->json('get', 'api/v1/posts/' . $post->id);

        $result = $response->assertStatus(200)->json('data');

        $this->assertEquals(data_get($result, 'id'), $post->id, 'Response Post ID not same as model id');

    }

    public function test_create()
    {
        Event::fake();
        $dummy = Post::factory()->make();

        $response = $this->json('post', 'api/v1/posts', $dummy->toArray());

        $result = $response->assertStatus(201)->json('data');

        Event::assertDispatched(PostCreated::class);
        $result = collect($result)->only(array_keys($dummy->getAttributes()));

        $result->each(function ($value, $field) use ($dummy) {
            $this->assertSame(data_get($dummy, $field), $value, 'Fillable is not same');
        });

    }

    public function test_update()
    {
        Event::fake();
        $dummy = Post::factory()->create();
        $dummy2 = Post::factory()->make();

        $response = $this->patch('api/v1/posts/' . $dummy->id, $dummy2->toArray());

        Event::assertDispatched(PostUpdated::class); // event fired!

        $result = $response->assertStatus(200)->json('data');

        $fillables = $dummy2->getFillable(); // get only fillable fields to compare

        array_walk_recursive($fillables, function ($value, $field) use ($dummy2, $result) {
            $this->assertSame(data_get($result, $value), $dummy2->$value, 'Failed to update post model');
        });
    }

    public function test_delete()
    {
        Event::fake();
        $dummy = Post::factory()->create();

        $response = $this->json('delete', 'api/v1/posts/' . $dummy->id);

        Event::assertDispatched(PostDeleted::class);

        $resault = $response->assertStatus(200);

        $this->expectException(ModelNotFoundException::class);

        Post::query()->findOrFail($dummy->id);

    }
}

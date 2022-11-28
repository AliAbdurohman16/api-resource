<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Post;
use Tests\TestCase;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    // public function read_all_post()
    // {
    //     // Given we have post in the database
    //     $post = Post::factory()->create();

    //     // when visit the posts URI
    //     $response = $this->get('api/posts');

    //     // He should be able to read the post
    //     $response->assertSee($post->title);
    // }

    public function insert_post()
    {
        // Given we have insert post
        $this->actingAs(Post::factory()->create());

        // And a post object
        $post = Post::factory()->make();

        // When submits post request to create post endpoint
        $this->post('api/posts', $post->toArray());

        // It gets stored in the database
        $this->assertEquals(1, Post::all()->count());
    }

    public function read_single_post()
    {
        // Given we have post in the database
        $post = Post::factory()->create();

        // when visit the posts URI
        $response = $this->get('api/posts/'.$post->id);

        // He should be able to read the post
        $response->assertSee($post->title)->assertSee($post->content);
    }
}

<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_guest_cannot_access_posts_index()
    {
        $response = $this->get(route('posts.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_can_access_posts_index()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    public function test_guest_cannot_access_posts_show()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('posts.show', $post));

        $response->assertRedirect(route('login'));
    }

    public function test_user_can_access_posts_show()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('posts.show', $post));

        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    public function test_guest_cannot_access_posts_create()
    {
        $response = $this->get(route('posts.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_can_access_posts_create()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('posts.create'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_posts_store()
    {
        $post = [
            'title' => 'プログラミング学習1日目',
            'content' => '今日からプログラミング学習開始！頑張るぞ！'
        ];

        $response = $this->post(route('posts.store'), $post);

        $this->assertDatabaseMissing('posts', $post);
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_access_posts_store()
    {
        $user = User::factory()->create();

        $post = [
            'title' => 'プログラミング学習1日目',
            'content' => '今日からプログラミング学習開始！頑張るぞ！'
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $post);

        $this->assertDatabaseHas('posts', $post);
        $response->assertRedirect(route('posts.index'));
    }

    public function test_guest_cannot_access_posts_edit()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('posts.edit', $post));

        $response->assertRedirect(route('login'));
    }

    public function test_user_cannot_access_others_posts_edit()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $others_post = Post::factory()->create(['user_id' => $other_user->id]);

        $response = $this->actingAs($user)->get(route('posts.edit', $others_post));

        $response->assertRedirect(route('posts.index'));
    }

    public function test_user_can_access_own_posts_edit()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('posts.edit', $post));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_update_post()
    {
        $user = User::factory()->create();
        $old_post = Post::factory()->create(['user_id' => $user->id]);

        $new_post = [
            'title' => 'プログラミング学習1日目',
            'content' => '今日からプログラミング学習開始！頑張るぞ！'
        ];

        $response = $this->patch(route('posts.update', $old_post), $new_post);

        $this->assertDatabaseMissing('posts', $new_post);
        $response->assertRedirect(route('login'));
    }

    public function test_user_cannot_update_others_post()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $others_old_post = Post::factory()->create(['user_id' => $other_user->id]);

        $new_post = [
            'title' => 'プログラミング学習1日目',
            'content' => '今日からプログラミング学習開始！頑張るぞ！'
        ];

        $response = $this->actingAs($user)->patch(route('posts.update', $others_old_post), $new_post);

        $this->assertDatabaseMissing('posts', $new_post);
        $response->assertRedirect(route('posts.index'));
    }

    public function test_user_can_update_own_post()
    {
        $user = User::factory()->create();
        $old_post = Post::factory()->create(['user_id' => $user->id]);

        $new_post = [
            'title' => 'プログラミング学習1日目',
            'content' => '今日からプログラミング学習開始！頑張るぞ！'
        ];

        $response = $this->actingAs($user)->patch(route('posts.update', $old_post), $new_post);

        $this->assertDatabaseHas('posts', $new_post);
        $response->assertRedirect(route('posts.show', $old_post));
    }
}

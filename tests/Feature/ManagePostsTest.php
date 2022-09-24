<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;

class ManagePostsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    /** @test */
    public function user_can_create_a_post() : void
    {
        // user buka halaman daftar post
        $this->visit('/post');

        // user klik tombol buat post baru
        $this->click('create-new-post');

        // user lihat url yang dituju sesuai
        $this->seePageIs('/post/create');

        // tampil form create post
        $this->seeElement('form', [
            'id' => 'create-post',
            'action' => route('post.store')
        ]);

        // user submit form berisi title, content, dan status
        $this->submitForm('Save', [
            'title' => 'Belajar Laravel 8',
            'content' => 'ini content belajar laravel 8',
            'status' => 1 // publish
        ]);

        // lihat halaman web ter-redirect ke url sesuai dengan target
        $this->seePageIs('/post');

        // terdapat record baru sesuai dengan post yang disubmit user
        $this->seeInDatabase('posts', [
            'title' => 'Belajar Laravel 8',
            'content' => 'ini content belajar laravel 8',
            'status' => 1
        ]);
    }

    /** @test */
    public function user_can_browse_posts_index_page() : void
    {
        // generate 2 record baru di table `posts`
        $postOne = Post::create([
            'title' => 'Belajar Laravel 8 edisi satu',
            'content' => 'ini content belajar laravel 8 edisi satu',
            'status' => 1,
            'slug' => 'belajar-laravel-8-edisi-1'
        ]);

        $postTwo = Post::create([
            'title' => 'Belajar Laravel 8 edisi dua',
            'content' => 'ini content belajar laravel 8 edisi dua',
            'status' => 1,
            'slug' => 'belajar-laravel-8-edisi-2'
        ]);

        // user buka halaman index post
        $this->visit('/post');

        // user lihat dua title dari post yang digenerate
        $this->see('Belajar Laravel 8 edisi satu');
        $this->see('Belajar Laravel 8 edisi dua');

        // user lihat button edit untuk masing-masing post
        $this->seeElement('a', [
            'id' => 'edit-post-' . $postOne->id,
            'href' => route('post.edit', $postOne->id)
        ]);

        $this->seeElement('a', [
            'id' => 'edit-post-' . $postTwo->id,
            'href' => route('post.edit', $postTwo->id)
        ]);

        // user lihat button delete untuk masing-masing post
        $this->seeElement('button', [
            'id' => 'delete-post-' . $postOne->id
        ]);

        $this->seeElement('button', [
            'id' => 'delete-post-' . $postTwo->id
        ]);

    }

    /** @test */
    public function user_can_edit_existing_post() : void
    {
        // generate 1 data post
        $post = Post::create([
            'title' => 'Belajar laravel 8',
            'content' => 'Ini content belajar laravel 8',
            'status' => 1,
            'slug' => 'belajar-laravel-8'
        ]);

        // user buka halaman daftar post
        $this->visit('/post');

        // user klik tombol edit post
        $this->click('edit-post-' . $post->id);

        // lihat halaman url yang dituju
        $this->seePageIs("/post/{$post->id}/edit");

        // tampil form edit data post
        $this->seeElement('form', [
            'action' => url('/post/' . $post->id)
        ]);

        // user submit data post yang diperbaharui
        $this->submitForm('Update', [
            'title' => 'Belajar Laravel 8 edisi revisi',
            'content' => 'ini content belajar laravel 8 edisi revisi'
        ]);

        // lihat halaman web yang dialihkan
        $this->seePageIs('/post');

        // data post di database berubah sesuai dengan data yang disubmit
        $this->seeInDatabase('posts', [
            'id' => $post->id,
            'title' => 'Belajar Laravel 8 edisi revisi',
            'content' => 'ini content belajar laravel 8 edisi revisi'
        ]);
    }

    /** @test  */
    public function user_can_delete_existing_post() : void
    {
        // generate 1 data post
        $post = Post::create([
            'title' => 'Belajar Laravel 8',
            'content' => 'ini content belajar laravel 8',
            'status' => 1,
            'slug' => 'belajar-laravel-8'
        ]);

        // user buka halaman daftar post
        $this->visit('/post');

        // user tekan delete untuk post 1
        $this->press('delete-post-'.$post->id);

        // lihat halaman ter-redirect
        $this->seePageIs('post');

        // data post di database sudah terhapus
        $this->dontSeeInDatabase('posts', [
            'id' => $post->id
        ]);
    }
}

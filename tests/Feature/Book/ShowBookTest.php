<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\BookIndex;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowBookTest extends TestCase
{
    public function test_to_show_some_book()
    {
        $user = User::factory()->create();
        $book = Book::factory([
            'publisher_user_id' => $user->id
        ])->create();
        $bookIndexFactory = BookIndex::factory([
            'book_id' => $book->id,
            'index_id' => null,
        ])->count(10)->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/livros/'.$book->id);

        $response->assertStatus(200);
    }

    public function test_to_show_some_invalid_book(){
        $user = User::factory()->create();
        $book = Book::factory([
            'publisher_user_id' => $user->id
        ])->create();
        $bookIndexFactory = BookIndex::factory([
            'book_id' => $book->id,
            'index_id' => null,
        ])->count(10)->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/livros/'.$book->id+1);

        $response->assertStatus(404);
    }

    public function test_to_show_some_book_as_guest_user(){
        $user = User::factory()->create();
        $book = Book::factory([
            'publisher_user_id' => $user->id
        ])->create();
        $bookIndexFactory = BookIndex::factory([
            'book_id' => $book->id,
            'index_id' => null,
        ])->count(10)->create();


        $response = $this->getJson('/api/v1/livros/'.$book->id);

        $response->assertStatus(401);
    }
}

<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\BookIndex;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteBookTest extends TestCase
{

    public function test_to_delete_an_book()
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

        $response = $this->deleteJson('/api/v1/livros/'.$book->id);

        $response->assertNoContent();
    }

    public function test_to_delete_an_non_existing_book(){
        $user = User::factory()->create();
        $book = Book::factory([
            'publisher_user_id' => $user->id
        ])->create();
        $bookIndexFactory = BookIndex::factory([
            'book_id' => $book->id,
            'index_id' => null,
        ])->count(10)->create();

        Sanctum::actingAs($user);

        $response = $this->deleteJson('/api/v1/livros/'.$book->id+1);

        $response->assertNotFound();
    }

    public function test_to_delete_an_book_without_loggin(){
        $user = User::factory()->create();
        $book = Book::factory([
            'publisher_user_id' => $user->id
        ])->create();
        $bookIndexFactory = BookIndex::factory([
            'book_id' => $book->id,
            'index_id' => null,
        ])->count(10)->create();


        $response = $this->deleteJson('/api/v1/livros/'.$book->id+1);

        $response->assertUnauthorized();
    }
}

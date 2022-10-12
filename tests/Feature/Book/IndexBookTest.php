<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\BookIndex;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IndexBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_to_index_existent_book()
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

        $response = $this->getJson('api/v1/livros?titulo='.$book->title);

        $response->assertOk();
    }

    public function test_to_find_an_nonexistent_book()
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

        $response = $this->getJson('api/v1/livros?titulo=IssoNaoExiste');

        $response->assertOk()->assertJson([
            'success' => true,
            'data' => [],
        ]);
    }

    public function test_to_find_an_book_without_login() {
        $user = User::factory()->create();
        $book = Book::factory([
            'publisher_user_id' => $user->id
        ])->create();
        $bookIndexFactory = BookIndex::factory([
            'book_id' => $book->id,
            'index_id' => null,
        ])->count(10)->create();


        $response = $this->getJson('api/v1/livros?titulo='.$book->title);

        $response->assertUnauthorized();
    }
}

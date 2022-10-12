<?php

namespace App\Services\Books;

use App\Models\Book;
use App\Services\BaseService;
use Exception;

class BookService extends BaseService  {

    /**
     * This Method will create a new Book
     * @param array $bookAttributes
     * @return array
     * @throws Exception
     */
    public function create(array $bookAttributes):array {
        $title = $this->validateTitle($bookAttributes);

        $book = Book::create([
            'publisher_user_id' => auth()->user()->id,
            'title' =>  $title,
        ]);

        if ($book)
            return [
                'success' => true,
                'message' => 'Livro criado com sucesso',
                'data' => $book,
            ];
        else
            throw new Exception('Falha ao criar o livro');
    }

    public function update(array $bookAttributes, Book $book): array {
        $title = $this->validateTitle($bookAttributes);

        $updated = $book->update([
            'title' =>  $title,
        ]);

        if ($updated)
            return [
                'success' => true,
                'message' => 'Livro criado com sucesso',
                'data' => $book,
            ];
        else
            throw new Exception('Falha ao criar o livro');
    }
}

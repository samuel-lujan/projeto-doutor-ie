<?php

namespace App\Services\Books;

use App\Models\Book;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BookService extends BaseService  {

    /**
     * This Method will find books by they title, they creator or by they indexes
     * @param array $attributes
     * @return Collection
     */
    public function index(array $attributes): Collection {
        $books = Book::with(['publisher', 'index']);

        if (isset($attributes['titulo']))
            $books = $books->where('title', $attributes['titulo']);

        if (isset($attributes['publicador']))
            $books = $books->whereHas('publisher', function($query) use ($attributes) {
                $query->where('name', 'like', "%".$attributes['publicador']."%");
            });

        if (isset($attributes['indice']))
            $books = $books->whereHas('index',  function($query) use ($attributes) {
                $query->where('title', 'like', '%'.$attributes['indice'].'%');
            });

        return $books->get();
    }

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

        if (isset($bookAttributes['document'])){
            $book->clearMediaCollection('livros');
            $book->addMediaFromBase64($bookAttributes['document'], ['pdf', '.pdf', 'application/pdf'])->toMediaCollection('livros', 'public');
        }

        if ($book)
            return [
                'success' => true,
                'message' => 'Livro criado com sucesso',
                'data' => $book,
            ];
        else
            throw new Exception('Falha ao criar o livro');
    }

    /**
     * This Method will update a Book
     * @param array $bookAttributes
     * @param Book $book
     * @return array
     * @throws Exception
     */
    public function update(array $bookAttributes, Book $book): array {
        $title = $this->validateTitle($bookAttributes);

        $updated = $book->update([
            'title' =>  $title,
        ]);

        if (isset($bookAttributes['document'])){
            $book->clearMediaCollection('livros');
            $book->addMediaFromBase64($bookAttributes['document'], ['pdf', '.pdf', 'application/pdf'])->toMediaCollection('livros', 'public');
        }

        if ($updated)
            return [
                'success' => true,
                'message' => 'Livro criado com sucesso',
                'data' => $book,
            ];
        else
            throw new Exception('Falha ao criar o livro');
    }

    /**
     * This Method will delete an book
     * @param Book $book
     * @return array
     * @throws Exception
     */
    public function delete(Book $book):array {
        Media::where('model_type', "App\Models\Book")->where('model_id', $book->id)->delete();

        if ($book->delete())
            return [
                'success' => true,
                'message' => 'Livro apagado com sucesso',
            ];

        throw new Exception("Falha ao apagar o livro");

    }
}

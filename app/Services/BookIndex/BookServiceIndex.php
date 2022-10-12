<?php

namespace App\Services\BookIndex;

use App\Models\Book;
use App\Models\BookIndex;
use App\Services\BaseService;
use Exception;

class BookServiceIndex extends BaseService
{
    /**
     * This Method will create the indexes of one book
     * @param array $bookIndexes
     * @param Book $book
     * @return array
     */
    public function create(array $bookIndexes, Book $book): array
    {
        $this->buildIndex($bookIndexes, $book);

        return [
            'success' => true,
            'message' => "Todos os indexes foram criados com sucesso",
        ];
    }

    /**
     * This Method will update the indexes of one book
     * @param array $bookIndexes
     * @param Book $book
     * @return array
     */
    public function update(array $bookIndexes, Book $book): array{
        $this->updateIndex($bookIndexes, $book);

        return [
            'success' => true,
            'message' => "Todos os indexes foram atualizados com sucesso",
        ];
    }

    private function createIndex(array $index, Book $book, int $bookIndexId = null): BookIndex
    {
        return BookIndex::create([
            'book_id'   =>  $book->id,
            'index_id'  =>  $bookIndexId,
            'title'     =>  $this->validateTitle($index),
            'page'      =>  $index['pagina'],
        ]);
    }

    public function buildIndex($indexes, Book $book, int $indexId = null){
        foreach ($indexes as $index) {
            $bookIndex = $this->createIndex($index, $book, $indexId);

            if (isset($index['subindices'])){
                $bookIndex = $this->buildIndex($index['subindices'], $book, $bookIndex->id);
            }
        }
    }

    public function updateIndex($indexes, Book $book, int $indexId = null){
        $book->index()->delete();

        foreach ($indexes as $index) {

            $bookIndex = $this->createIndex($index, $book, $indexId);

            if (isset($index['subindices'])){
                $bookIndex = $this->buildIndex($index['subindices'], $book, $bookIndex->id);
            }
        }
    }

}

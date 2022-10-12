<?php

namespace App\Http\Controllers;

use App\Http\Requests\Books\StoreBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookIndex\BookServiceIndex;
use App\Services\Books\BookService;
use Exception;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    private BookService $bookService;
    private BookServiceIndex $bookIndexService;

    public function __construct(BookService $bookService, BookServiceIndex $bookIndexService)
    {
        $this->bookService = $bookService;
        $this->bookIndexService = $bookIndexService;
    }

    public function index() {

    }

    public function show(Book $book) {
        return new BookResource($book);
    }

    public function store(StoreBookRequest $request) {
        $attributes = $request->all();

        try {
            $bookResponse = $this->bookService->create($attributes);
            $book = $bookResponse['data'];
            $this->bookIndexService->create($attributes['indices'], $book);

        } catch (Exception $e) {
            Log::error("Houve uma falha ao criar o livro {$e->getMessage()}", $e->getTrace());
            return response()->json([
                'success' => false,
                'message' => 'Houve uma falha ao criar o livro',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Livro cadastrado com sucesso',
            'data' => $book,
        ], 201);
    }

    public function update(StoreBookRequest $request, Book $book) {
        $attributes = $request->validated();

        try {
            $bookResponse = $this->bookService->update($attributes, $book);
            $book = $bookResponse['data'];
            $this->bookIndexService->update($attributes['indices'], $book);

        } catch (Exception $e) {
            Log::error("Houve uma falha ao editar o livro {$e->getMessage()}", $e->getTrace());
            return response()->json([
                'success' => false,
                'message' => 'Houve uma falha ao editar o livro',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Livro editado com sucesso',
            'data' => $book,
        ], 200);
    }

    public function delete(Book $book){

        try {
            $this->bookService->delete($book);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => "Livro apagado com sucesso",
        ], 204);
    }
}

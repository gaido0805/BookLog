<?php

namespace App\Interfaces\Controllers;

use App\Domain\Entities\Book;
use App\Domain\UseCases\Book\CreateBookUseCase;
use App\Domain\UseCases\Book\DeleteBookUseCase;
use App\Domain\UseCases\Book\GetUserBooksUseCase;
use App\Domain\UseCases\Book\UpdateBookUseCase;
use App\Interfaces\Requests\CreateBookRequest;
use App\Interfaces\Requests\UpdateBookRequest;
use App\Interfaces\Resources\BookResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private CreateBookUseCase $createBookUseCase;
    private GetUserBooksUseCase $getUserBooksUseCase;
    private UpdateBookUseCase $updateBookUseCase;
    private DeleteBookUseCase $deleteBookUseCase;

    public function __construct(
        CreateBookUseCase $createBookUseCase,
        GetUserBooksUseCase $getUserBooksUseCase,
        UpdateBookUseCase $updateBookUseCase,
        DeleteBookUseCase $deleteBookUseCase
    ) {
        $this->createBookUseCase = $createBookUseCase;
        $this->getUserBooksUseCase = $getUserBooksUseCase;
        $this->updateBookUseCase = $updateBookUseCase;
        $this->deleteBookUseCase = $deleteBookUseCase;
    }

    public function index(Request $request): JsonResponse
    {
        $books = $this->getUserBooksUseCase->execute($request->user()->id);

        return response()->json([
            'books' => BookResource::collection($books),
        ]);
    }

    public function store(CreateBookRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $book = $this->createBookUseCase->execute($data);

        return response()->json([
            'book' => new BookResource($book),
        ], 201);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $book = Book::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response()->json([
            'book' => new BookResource($book),
        ]);
    }

    public function update(UpdateBookRequest $request, int $id): JsonResponse
    {
        $book = Book::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $updatedBook = $this->updateBookUseCase->execute($book, $request->validated());

        return response()->json([
            'book' => new BookResource($updatedBook),
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $book = Book::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $this->deleteBookUseCase->execute($book);

        return response()->json([
            'message' => 'Book deleted successfully',
        ]);
    }
}

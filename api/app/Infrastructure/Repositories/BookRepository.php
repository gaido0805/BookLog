<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Book;
use App\Domain\Repositories\BookRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BookRepository implements BookRepositoryInterface
{
    public function create(array $data): Book
    {
        return Book::create($data);
    }

    public function findById(int $id): ?Book
    {
        return Book::find($id);
    }

    public function findByUserId(int $userId): Collection
    {
        return Book::where('user_id', $userId)->orderBy('read_date', 'desc')->get();
    }

    public function update(Book $book, array $data): Book
    {
        $book->update($data);
        return $book;
    }

    public function delete(Book $book): bool
    {
        return $book->delete();
    }
}

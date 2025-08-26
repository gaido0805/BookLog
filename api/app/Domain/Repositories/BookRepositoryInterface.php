<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Book;
use Illuminate\Database\Eloquent\Collection;

interface BookRepositoryInterface
{
    public function create(array $data): Book;
    public function findById(int $id): ?Book;
    public function findByUserId(int $userId): Collection;
    public function update(Book $book, array $data): Book;
    public function delete(Book $book): bool;
}

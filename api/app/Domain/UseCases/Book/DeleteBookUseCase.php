<?php

namespace App\Domain\UseCases\Book;

use App\Domain\Entities\Book;
use App\Domain\Repositories\BookRepositoryInterface;

class DeleteBookUseCase
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function execute(Book $book): bool
    {
        return $this->bookRepository->delete($book);
    }
}

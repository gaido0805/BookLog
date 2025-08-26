<?php

namespace App\Domain\UseCases\Book;

use App\Domain\Entities\Book;
use App\Domain\Repositories\BookRepositoryInterface;

class CreateBookUseCase
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function execute(array $data): Book
    {
        return $this->bookRepository->create($data);
    }
}

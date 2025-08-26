<?php

namespace App\Domain\UseCases\Book;

use App\Domain\Repositories\BookRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GetUserBooksUseCase
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function execute(int $userId): Collection
    {
        return $this->bookRepository->findByUserId($userId);
    }
}

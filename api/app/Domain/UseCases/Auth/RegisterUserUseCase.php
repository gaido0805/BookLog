<?php

namespace App\Domain\UseCases\Auth;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;

class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(array $data): User
    {
        return $this->userRepository->create($data);
    }
}

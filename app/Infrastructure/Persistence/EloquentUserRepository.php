<?php

namespace App\Infrastructure\Persistence;

use App\Classes\DTOs\User\CreateUserDTO;
use App\Domain\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EloquentUserRepository implements UserRepository
{
    public function store(CreateUserDTO $dto, int $personId): User
    {
        return User::create([
            'person_id' => $personId,
            'password' => Hash::make($dto->password),
        ]);
    }

    public function existsByPerson(string $email): ?User
    {
        return User::whereHas('person', function ($query) use ($email) {
            $query->where('email', $email);
        })->first();
    }
}
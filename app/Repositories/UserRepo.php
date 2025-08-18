<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepo;

class UserRepo implements IUserRepo
{
    private User $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function checkIfUserMobileExists(string $mobile): bool
    {
        return $this->model
            ->where('mobile', 'like', "%{$mobile}%")
            ->exists();
    }

    public function getUserByMobile(string $mobile): ?User
    {
        return $this->model
            ->where('mobile', $mobile)
            ->first();
    }

    public function createUser(array $data): User
    {
        return $this->model
            ->create($data);
    }
}

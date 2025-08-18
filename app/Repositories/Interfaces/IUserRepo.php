<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface IUserRepo
{
    public function checkIfUserMobileExists(string $mobile): bool;

    public function getUserByMobile(string $mobile): ?User;

    public function createUser(array $data): User;
}

<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface IUserRepo
{
    public function checkIfUserMobileExists(string $mobile): bool;

    public function getUserByMobile(string $mobile): ?User;
}

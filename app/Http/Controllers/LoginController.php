<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetUserMobileRequest;
use App\Repositories\Interfaces\IUserRepo;

class LoginController extends Controller
{
    private IUserRepo $userRepo;

    public function __construct(IUserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function checkMobile(GetUserMobileRequest $request)
    {
        $exist = $this->userRepo
            ->checkIfUserMobileExists(
                mobile: $request->get('mobile'),
            );

        if ($exist){
            //login
            return view('auth.password');
        }else{
            //register
            return view('auth.otp');
        }
    }
}

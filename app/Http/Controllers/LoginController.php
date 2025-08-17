<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckPasswordRequest;
use App\Http\Requests\GetUserMobileRequest;
use App\Repositories\Interfaces\IUserRepo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
            return view('auth.password', ['mobile' => $request->get('mobile')]);
        }else{
            //register
            return view('auth.otp');
        }
    }

    /**
     * @throws ValidationException
     */
    public function checkPassword(CheckPasswordRequest $request)
    {
        $user = $this->userRepo
            ->getUserByMobile(
                mobile: $request->get('mobile'),
            );
        if (is_null($user)){
            throw ValidationException::withMessages([
                "mobile" => [
                    'User not registered!'
                ],
            ]);
        }

        if (!Hash::check($request->get('password'), $user->password)) {
            throw ValidationException::withMessages([
                "password" => [
                    'Invalid password!'
                ],
            ]);
        }

        return view('dashboard');
    }

    public function checkOtp(GetUserMobileRequest $request)
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

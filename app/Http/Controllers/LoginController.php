<?php

namespace App\Http\Controllers;

use App\Jobs\SendOtp;
use App\Http\Requests\CheckPasswordRequest;
use App\Http\Requests\GetUserMobileRequest;
use App\Repositories\Interfaces\IUserRepo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
        if (auth()->check()) {
            return redirect('/dashboard');
        }

        return view('auth.login');
    }

    public function checkMobile(GetUserMobileRequest $request)
    {
        $exist = $this->userRepo
            ->checkIfUserMobileExists(
                mobile: $request->get('mobile'),
            );

        /*
         * agar karbar ba shomare mobile morede nazar vujud dashte bashad,
         * be safheye daryafte password hedayat shode va farayande login aghaz mishavad.
         */
        if ($exist) {
            return view('auth.password', ['mobile' => $request->get('mobile')]);
        }else {
            /*
             * agar karbar vujud nadashte bashad, jobe marbut be ersale otp(one time password) dispatch mishavad.
             * va be safheye daryafte otp hedayat shode va farayande login aghaz mishavad.
             */
            SendOtp::dispatch($request->get('mobile'))
                ->onConnection('redis')
                ->onQueue('otp');

            return view('auth.otp', ['mobile' => $request->get('mobile')]);
        }
    }

    /**
     * @throws ValidationException
     */
    public function checkPassword(CheckPasswordRequest $request)
    {
        /*
         * ebteda check mikonim karbar ba mobile morede nazar vujud dashte bashad.
         * agar vujud nadasht khatta midahim.
         */
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

        /*
         * password karbar ra check mikonim ta sahih bashad,
         * agar eshtebah bud khata midahim.
         */
        if (!Hash::check($request->get('password'), $user->password)) {
            throw ValidationException::withMessages([
                "password" => [
                    'Invalid password!'
                ],
            ]);
        }

        /*
         * dar nahayat agar inja hastim yani password-e karbar be dorosti vared shode
         * va be safheye dashboard hedayat mikonim.
         */
        return view('dashboard');
    }

    public function checkOtp(GetUserMobileRequest $request)
    {
        $mobile = $request->get('mobile');

        // Registration submission branch
        if ($request->has('first_name')) {
            $validator = Validator::make($request->all(), [
                'first_name' => ['required','string','max:100'],
                'last_name' => ['required','string','max:100'],
                'national_code' => ['required','digits:10'],
                'password' => ['required','string','min:6'],
            ]);
            if ($validator->fails()) {
                return view('auth.register', ['mobile' => $mobile])
                    ->withErrors($validator)
                    ->withInput();
            }

            $exists = $this->userRepo->checkIfUserMobileExists($mobile);
            if ($exists) {
                return view('auth.password', ['mobile' => $mobile])
                    ->withErrors(['mobile' => 'این شماره قبلا ثبت شده است.']);
            }

            $this->userRepo->createUser([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'mobile' => $mobile,
                'national_code' => $request->get('national_code'),
                'password' => Hash::make($request->get('password')),
            ]);

            return view('dashboard');
        }

        // OTP verification branch
        $validator = Validator::make($request->all(), [
            'otp' => ['required','digits:6'],
        ]);
        if ($validator->fails()) {
            return view('auth.otp', ['mobile' => $mobile])
                ->withErrors($validator)
                ->withInput();
        }

        $cacheKey = 'otp:mobile:' . $mobile;
        $cachedOtp = Cache::store('redis')->get($cacheKey);
        if (!$cachedOtp || $cachedOtp !== $request->get('otp')) {
            return view('auth.otp', ['mobile' => $mobile])
                ->withErrors(['otp' => 'کد تایید نامعتبر است یا منقضی شده است.'])
                ->withInput();
        }

        Cache::store('redis')->forget($cacheKey);
        return view('auth.register', ['mobile' => $mobile]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/auth');
    }
}

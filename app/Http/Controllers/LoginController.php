<?php

namespace App\Http\Controllers;

use App\Jobs\SendOtp;
use App\Http\Requests\CheckPasswordRequest;
use App\Http\Requests\GetUserMobileRequest;
use App\Http\Requests\CheckOtpRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Repositories\Interfaces\IUserRepo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
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
            $mobile = $request->get('mobile');
            $rateKey = 'otp_rl:' . $mobile . ':' . $request->ip();
            if (RateLimiter::tooManyAttempts($rateKey, 3)) {
                return view('auth.otp', ['mobile' => $mobile])
                    ->withErrors(['otp' => "تعداد درخواست‌ها زیاد است. لطفاً 1دقیقه دیگر تلاش کنید."]);
            }
            RateLimiter::hit($rateKey, 60);

            SendOtp::dispatch($mobile)
                ->onConnection('redis')
                ->onQueue('otp');

            return view('auth.otp', ['mobile' => $mobile]);
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
         * dar nahayat agar inja hastim yani passworde karbar be dorosti vared shode
         * va be safheye dashboard hedayat mikonim.
         */
        return view('dashboard');
    }

    public function checkOtp(CheckOtpRequest $request)
    {
        $mobile = $request->get('mobile');
        /*
         * agar be in gesmat resid montazer code otp hastim va barasi mikonim code otp ba shomare mobile dorost bashad.
         */
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

    public function registerUser(RegisterUserRequest $request)
    {
        $mobile = $request->get('mobile');
        /*
         * agar shomare vjud dasht be safhe password hedayt mikonim agar vjud nadasht karbar jadid saxte mishe
         * va be dashbord hedayt mishe.
         */
        $exists = $this->userRepo->checkIfUserMobileExists($mobile);
        if ($exists) {
            return view('auth.password', ['mobile' => $mobile])
                ->withErrors(['mobile' => 'این شماره قبلا ثبت شده است.']);
        }

        // user jadid ijad mishavad
        $this->userRepo->createUser($request->registrationPayload());

        return view('dashboard');
    }

    /*
     * Logout
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/auth');
    }
}

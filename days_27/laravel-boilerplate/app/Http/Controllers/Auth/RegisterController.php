<?php

namespace App\Http\Controllers\Auth;

use App\Models\Auth\Role\Role;
use App\Notifications\Auth\ConfirmEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\Auth\User\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Ramsey\Uuid\Uuid;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        if (config('auth.captcha.registration')) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    protected function create(array $data)
    {
        /** @var  $user User */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => Uuid::uuid4(),
            'confirmed' => false,
            'google2fa_secret' => $data['google2fa_secret'] ?? null,
        ]);

        if (config('auth.users.default_role')) {
            $user->roles()->attach(Role::firstOrCreate(['name' => config('auth.users.default_role')]));
        }

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());

        // $google2fa = app('pragmarx.google2fa');
        // $registration_data = $request->all();
        // $registration_data['google2fa_secret'] = $google2fa->generateSecretKey();
        // $request->session()->flash('registration_data', $registration_data);

        // $QR_Image = $google2fa->getQrCodeInline(
        //     config('app.name'),
        //     $registration_data['email'],
        //     $registration_data['google2fa_secret']
        // );

        // return view('google2fa.register', ['QR_Image' => $QR_Image, 'secret' => $registration_data['google2fa_secret']]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if (config('auth.users.confirm_email') && !$user->confirmed) {

            $this->guard()->logout();

            $user->notify(new ConfirmEmail());

            return redirect(route('login'));
        }
    }

    // public function showCompleteRegistration()
    // {
    //     return view('complete-registration');
    // }

    // public function completeRegistration(Request $request)
    // {
    //     $registration_data = $request->session()->get('registration_data');

    //     if (!$registration_data) {
    //         return redirect()->route('login')->with('error', 'Session expired. Please register again.');
    //     }

    //     $google2fa = app('pragmarx.google2fa');

    //     if ($google2fa->verifyKey($registration_data['google2fa_secret'], $request->input('google2fa_token'))) {
    //         $user = User::create([
    //             'name' => $registration_data['name'],
    //             'email' => $registration_data['email'],
    //             'password' => bcrypt(Uuid::uuid4()), // Ganti jika Anda menggunakan password yang berbeda
    //             'confirmation_code' => Uuid::uuid4(),
    //             'confirmed' => true,
    //             'active' => true,
    //             'google2fa_secret' => $registration_data['google2fa_secret'],
    //         ]);

    //         if (config('auth.users.default_role')) {
    //             $user->roles()->attach(Role::firstOrCreate(['name' => config('auth.users.default_role')]));
    //         }

    //         // Login pengguna
    //         // Auth::login($user);

    //         // Hapus data registrasi dari sesi
    //         // $request->session()->forget('registration_data');

    //         // Redirect ke halaman yang diinginkan setelah pendaftaran sukses
    //         return redirect()->route('/')->with('success', 'Registration completed successfully!');
    //     } else {
    //         return redirect()->back()->with('error', 'Invalid Google Authenticator code. Please try again.');
    //     }
    // }
}

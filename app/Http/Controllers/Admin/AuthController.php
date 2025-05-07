<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Address;
use App\Models\Animal;
use App\Models\AnimalPet;
use App\Models\City;
use App\Models\Country;
use App\Models\FpgaComponent;
use App\Models\Manufacturer;
use App\Models\Photo;
use App\Models\Standard;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// Class work with authentication and Admin main page
class AuthController extends Controller
{
    public function welcome()
    {
        $title = __('messages.main_page');

        return view('index', compact(
            'title',
            )
        );
    }

    // Admin Main Page
    public function index()
    {
        $title = __('messages.main_page');

        $user_count = User::query()->count();
        $component_count = FpgaComponent::query()->count();
        $manufacturer_count = Manufacturer::query()->count();
        $standard_count = Standard::query()->count();

        return view('admin.index', compact(
                'title',
                'user_count',
                'component_count',
                'manufacturer_count',
                'standard_count',
            )
        );
    }

    public function register()
    {
        return view('auth.register', ['title' => __('messages.register.register')]);
    }

    public function signup(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
        ]);

        if (!$user) {
            Log::error('Failed to create user for email: ' . $request->email);
            return back()->with('error', __('messages.register.error'));
        }
        $user->sendEmailVerificationNotification();

        //Auth::login($user, true);
        return to_route('login.show')
            ->with('success', __('messages.register.success'))
            ->with('email', $request->email); // Передаём email в сессию

    }

    // Enter into an account page (ONLY VIEW)
    public function login()
    {
        $title = __('messages.auth.login');

        return view('auth.login', compact('title'));
    }

    // Store information in session
    public function auth(LoginRequest $request)
    {
        $is_accepted = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->remember);

        if (!$is_accepted) {
            return back()->with('error', __('messages.auth.error'));
        }

        if (!Auth::user()->hasVerifiedEmail()) {
            $email = Auth::user()->email;
            Auth::logout();
            return back()
                ->with('error', __('messages.auth.email_not_verified'))
                ->with('email', $email);
        }

        $redirectRoute = Auth::user()->role == Role::ADMIN ? 'admin.home' : 'index';
        return to_route($redirectRoute)->with('success', __('messages.auth.success'));
    }

    // Logout from the account
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')->with('success', __('messages.auth.logout.success'));
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        Log::info("Email verification attempt for user ID: $id");

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('index')->with('error', __('messages.auth.verify_email_error_link'));
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('index')->with('success', __('messages.auth.verify_email_already_success'));
        }

        $user->markEmailAsVerified();
        Log::info('Email verified for user: ' . $user->email);

        Auth::login($user);

        return redirect()->route('index')->with('success', __('messages.auth.verify_email_success'));
    }

    public function showResendForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.resend-verification', [
            'title' => __('messages.auth.verify_email_resent_title'),
            'email' => $email,
        ]);
    }

    // Повторная отправка ссылки
    public function resendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login.show')->with('success', __('messages.auth.verify_email_already_success'));
        }

        $user->sendEmailVerificationNotification();

        return redirect()->route('login.show')->with('success', __('messages.auth.verify_email_resent'));
    }
}

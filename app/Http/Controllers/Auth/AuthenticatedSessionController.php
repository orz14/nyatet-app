<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login', [
            'title' => 'Masuk',
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('login');
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Get user info from provider
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     *
     * @param    $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $field = strtolower($provider).'_id';
        $authUser = User::where($field, $user->getId())->first();
        if ($authUser) {
            $authUser['avatar'] = $user->getAvatar() ?? null;
            $authUser->save();

            return $authUser;
        }

        // find user with same email
        if ($user->getEmail() != null) {
            $usermail = User::where('email', $user->getEmail())->first();
            if ($usermail) {
                // update provider id
                $usermail[$field] = $user->getId();
                $usermail['avatar'] = $user->getAvatar() ?? null;
                $usermail->save();

                return $usermail;
            } else {
                $user = User::create([
                    'name' => $user->getName() ?? 'User',
                    'username' => 'user-'.$this->genRandom(10),
                    'email' => $user->getEmail(),
                    'password' => Hash::make($this->genRandom(20)),
                    $field => $user->getId(),
                    'avatar' => $user->getAvatar() ?? null,
                    'role_id' => 2,
                ]);

                event(new Registered($user));

                return $user;
            }
        }
    }

    public function genRandom($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }
}

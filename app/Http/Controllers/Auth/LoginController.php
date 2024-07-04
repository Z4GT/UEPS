<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.signin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rememberMe = $request->rememberMe ? true : false;

        if (Auth::attempt($credentials, $rememberMe)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($this->isTwoFactorAuthenticationEnabled($user)) {
                Auth::logout();
                $request->session()->put('login.id', $user->id);
                $request->session()->put('login.remember', $request->boolean('remember'));

                return redirect()->route('two-factor.login');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'message' => 'Las Credenciales ingresadas son incorrectas.',
        ])->withInput($request->only('email'));
    }

    private function isTwoFactorAuthenticationEnabled($user): bool
    {
        return $user->two_factor_secret &&
               $user->two_factor_confirmed_at &&
               in_array(
                   \Laravel\Fortify\TwoFactorAuthenticatable::class,
                   class_uses_recursive($user)
               );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/sign-in');
    }
}

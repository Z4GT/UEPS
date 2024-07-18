<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Writer as BaconQrCodeWriter;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use App\Notifications\TwoFactorCode;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.signin');
    }

    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rememberMe = $request->rememberMe ? true : false;

        $user = User::where('email', $request->email)->first();

        // Verificar si el usuario está inactivo
        if ($user && !$user->status) {
            return redirect('/sign-in')->with('error', 'Este usuario está inactivo, contacta a un administrador');
        }

        if ($user && Auth::attempt($credentials, $rememberMe)) {
            $request->session()->regenerate();

            // Verificar si el usuario no tiene roles
            if ($user->roles->isEmpty()) {
                Auth::logout();
                return redirect('/sign-in')->with('error', 'Espera a que un administrador te asigne un rol.');
            } else {
                $redirectTo = '/';
            }

            // // Verificar si el usuario tiene roles específicos
            // if ($user->hasRole('administrador')) {
            //     $redirectTo = '/dashboard';
            // } elseif ($user->hasRole('auditor')) {
            //     $redirectTo = '/audits';
            // } else {
            //     Auth::logout();
            //     return redirect('/sign-in')->with('error', 'No tiene los permisos necesarios para acceder al sistema.');
            // }

            if ($user->two_factor_enabled) {
                $token = (new Google2FA)->generateSecretKey();
                $user->update([
                    'token_login' => $token,
                    'two_factor_expires_at' => Carbon::now()->addMinutes(10),
                ]);

                return redirect()->route('login.2fa.form', ['user' => $user->id, 'redirectTo' => $redirectTo]);
            } else {
                return redirect()->intended($redirectTo);
            }
        }

        return back()->withErrors([
            'message' => 'Las Credenciales ingresadas son incorrectas.',
        ])->withInput($request->only('email'));
    }

    public function createUserUrlQR($user)
    {
        $bacon = new BaconQrCodeWriter(new ImageRenderer(
            new RendererStyle(200),
            new ImagickImageBackEnd()
        ));

        $data = $bacon->writeString(
            (new Google2FA)->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $user->token_login
            ),
            'utf-8'
        );

        return 'data:image/png;base64,' . base64_encode($data);
    }

    public function login2FA(Request $request, User $user)
    {
        $request->validate(['code_verification' => 'required']);

        logger()->info('User token_login:', ['token_login' => $user->token_login]);
        logger()->info('User entered code:', ['code_verification' => $request->code_verification]);

        $google2fa = new Google2FA();
        $isValidGoogle2FA = $google2fa->verifyKey($user->token_login, $request->code_verification);
        $isValidToken = $request->code_verification === $user->token_login;

        logger()->info('2FA verification result:', ['isValidGoogle2FA' => $isValidGoogle2FA, 'isValidToken' => $isValidToken]);

        if ($isValidGoogle2FA || $isValidToken) {
            $request->session()->put('two_factor_authenticated', true);
            $request->session()->regenerate();

            Auth::login($user);

            // Limpiar el código de dos factores después de la autenticación exitosa
            $user->update(['token_login' => null, 'two_factor_expires_at' => null]);

            $redirectTo = $request->input('redirectTo', '/dashboard');
            return redirect()->intended($redirectTo);
        }

        return redirect()->route('login.2fa.form', ['user' => $user->id])->withErrors(['code_verification' => 'Código de verificación incorrecto']);
    }

    public function show2FAForm(User $user)
    {
        $urlQR = $this->createUserUrlQR($user);
        return view('auth.2fa', compact('urlQR', 'user'));
    }

    public function send2FACode(User $user)
    {
        $token = $user->token_login;

        if (!$token) {
            $token = (new Google2FA)->generateSecretKey();
            $user->update(['token_login' => $token]);
        }

        $user->notify(new TwoFactorCode($token));

        return redirect()->route('login.2fa.form', ['user' => $user->id])
            ->with('status', 'El código de verificación ha sido enviado a su correo.');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/sign-in');
    }
}

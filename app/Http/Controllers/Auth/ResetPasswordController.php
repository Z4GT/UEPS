<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function create(Request $request)
    {
        return view('auth.passrecover.reset-password', ['request' => $request]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Intentamos restablecer la contraseña del usuario. Si tiene éxito, actualizamos
        // la contraseña en el modelo del usuario y lo persistimos en la base de datos.
        // De lo contrario, analizamos el error y devolvemos la respuesta.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // Si la contraseña se restableció correctamente, redirigimos al usuario
        // a la vista de inicio autenticada de la aplicación. Si hay un error,
        // lo redirigimos de vuelta a donde vinieron con su mensaje de error.
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('sign-in')->with('status', __($status))
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}

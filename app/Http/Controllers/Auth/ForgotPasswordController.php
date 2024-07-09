<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function create()
    {
        return view('auth.passrecover.forgot-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $securityQuestion = $user->securityQuestion;

            if ($securityQuestion) {
                return response()->json([
                    'success' => true,
                    'security_question' => $securityQuestion->question,
                    'email' => $request->email
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Este usuario no tiene una pregunta de seguridad asociada.'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'error' => 'No se encontró un usuario con esta dirección de correo electrónico.'
        ]);
    }

    public function verifySecurityQuestion(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'security_answer' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->security_answer, $user->security_answer)) {
            // Generate a password reset token
            $token = Password::createToken($user);

            return response()->json([
                'success' => true,
                'reset_url' => url(route('password.reset', ['token' => $token, 'email' => $request->email], false))
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'La respuesta a la pregunta de seguridad es incorrecta.'
        ]);
    }
}

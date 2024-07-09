<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function create()
    {
        return view('auth.passrecover.forgot-password');
    }

    public function store(Request $request)
    {
        if (config('app.is_demo')) {
            return back()->with('error', "You are in a demo version, resetting password is disabled.");
        }

        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $securityQuestion = $user->securityQuestion;

            if ($securityQuestion) {
                return response()->json([
                    'success' => true,
                    'security_question' => $securityQuestion->pregunta,
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
            return response()->json([
                'success' => true,
                'reset_url' => route('password.reset', ['email' => $request->email])
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'La respuesta a la pregunta de seguridad es incorrecta.'
        ]);
    }
}

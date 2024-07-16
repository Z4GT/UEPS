<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;

class RegisterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.signup');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
            'last_name' => ['required', 'min:3', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:7|max:255',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'name.max' => 'El nombre no puede tener más de 255 caracteres',
            'name.regex' => 'El nombre solo puede contener letras y espacios',
            'last_name.required' => 'El apellido es obligatorio',
            'last_name.min' => 'El apellido debe tener al menos 3 caracteres',
            'last_name.max' => 'El apellido no puede tener más de 255 caracteres',
            'last_name.regex' => 'El apellido solo puede contener letras y espacios',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe ser una dirección de correo electrónico válida',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres',
            'email.unique' => 'El correo electrónico ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 7 caracteres',
            'password.max' => 'La contraseña no puede tener más de 255 caracteres',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'last_name' => $request->last_name,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($user));

        Auth::login($user);

        return redirect('/email/verify');
    }
}

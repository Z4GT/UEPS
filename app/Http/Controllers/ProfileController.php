<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PragmaRX\Google2FA\Google2FA;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        return view('modules.users.profile', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'status' => 'nullable|boolean',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except('profile_photo');

        if ($request->hasFile('profile_photo')) {
            // Borrar la imagen anterior si existe
            if ($user->profile_photo) {
                Storage::delete('public/profile_photos/' . $user->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('users', 'public/profile_photos');
        }

        // Actualizar la opción de autenticación de dos factores
        if ($request->has('two_factor_enabled')) {
            $user->two_factor_enabled = true;
            $user->token_login = (new Google2FA())->generateSecretKey();
        } else {
            $user->two_factor_enabled = false;
            $user->token_login = null;
        }

        $user->update($data);

        return back()->with('success', 'Tu perfil ha sido actualizado.');
    }
}

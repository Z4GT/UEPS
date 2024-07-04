<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use Laravel\Fortify\RecoveryCode;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('modules.users.profile', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'last_name' => 'required|min:3|max:255',
            'phone' => 'nullable|numeric|digits:10',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about' => 'max:255',
        ], [
            'name.required' => 'Name is required',
            'last_name.required' => 'Last name is required',
        ]);

        $data = $request->only('name', 'last_name', 'email', 'phone', 'about');
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('users', 'public/profile_photos');
        }

        $user->update($data);

        return back()->with('success', 'Tu perfil ha sido actualizado.');
    }

    public function enableTwoFactorAuthentication(Request $request)
    {
        $user = $request->user();
        $user->forceFill([
            'two_factor_secret' => encrypt(app(TwoFactorAuthenticationProvider::class)->generateSecretKey()),
            'two_factor_recovery_codes' => encrypt(json_encode(collect()->times(8, function () {
                return RecoveryCode::generate();
            })->all())),
        ])->save();

        return back()->with('status', 'two-factor-authentication-enabled');
    }

    public function confirmTwoFactorAuthentication(Request $request)
    {
        $user = $request->user();
        $provider = app(TwoFactorAuthenticationProvider::class);

        if ($provider->verify(decrypt($user->two_factor_secret), $request->input('code'))) {
            $user->forceFill([
                'two_factor_confirmed_at' => now(),
            ])->save();

            return back()->with('status', 'two-factor-authentication-confirmed');
        }

        return back()->withErrors(['code' => 'El código de autenticación de dos factores proporcionado no es válido.']);
    }

    public function disableTwoFactorAuthentication(Request $request)
    {
        $user = $request->user();
        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        return back()->with('status', 'two-factor-authentication-disabled');
    }

    public function regenerateRecoveryCodes(Request $request)
    {
        $user = $request->user();
        $user->forceFill([
            'two_factor_recovery_codes' => encrypt(json_encode(collect()->times(8, function () {
                return RecoveryCode::generate();
            })->all())),
        ])->save();

        return back()->with('status', 'two-factor-recovery-codes-regenerated');
    }
}

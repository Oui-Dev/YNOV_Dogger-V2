<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ProfilController extends Controller
{
    public function profil() {
        return Inertia::render("Dashboard/Profil");
    }

    public function update() {
        $user = auth()->user();

        $data = request()->validate([
            'lastname' => ['nullable', 'string', 'max:255'],
            'firstname' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable','email:rfc,dns,spoof','max:255', Rule::unique('users')->ignore($user->id)],
            'old_password' => ['required_with:password', 'string', function($attribute, $value, $fail) use ($user) {
                if(!Hash::check($value, $user->password)) {
                    $fail('Current password is incorrect');
                }
            }],
            'password' => ['required_with:old_password', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()],
        ]);

        $user->lastname = $data['lastname'] ?? $user->lastname;
        $user->firstname = $data['firstname'] ?? $user->firstname;
        $user->email = $data['email'] ?? $user->email;
        if(isset($data['password'])) $user->password = $data['password'];
        $user->save();

        return redirect()->route('dashboard.user.profil')->with('toast', [
            'type' => 'success',
            'message' => 'User created !',
        ]);
    }

    public function delete() {
        $user = request()->user();

        if($user->projects()->count() > 0) {
            return redirect()->route('dashboard.user.profil')->with('toast', [
                'type' => 'error',
                'message' => 'You can\'t delete your account because you have projects.',
            ]);
        }

        $user->delete();

        return redirect()->route('homepage')->with('toast', [
            'type' => 'success',
            'message' => 'User deleted !',
        ]);
    }
}

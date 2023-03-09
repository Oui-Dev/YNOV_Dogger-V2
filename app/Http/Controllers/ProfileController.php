<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show() {
        return Inertia::render("Dashboard/Profile");
    }

    public function update() {
        $user = auth()->user();

        $data = request()->validate([
            'lastname' => ['nullable', 'string', 'max:255'],
            'firstname' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable','email:rfc,dns,spoof','max:255', Rule::unique('users')->ignore($user->id)],
            'old_password' => ['required_with:password', 'nullable', 'string', function($attribute, $value, $fail) use ($user) {
                if(!Hash::check($value, $user->password)) {
                    $fail('Current password is incorrect');
                }
            }],
            'password' => ['required_with:old_password', 'nullable', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()],
        ]);

        $user->lastname = $data['lastname'] ?? $user->lastname;
        $user->firstname = $data['firstname'] ?? $user->firstname;
        $user->email = $data['email'] ?? $user->email;
        if(isset($data['password'])) $user->password = $data['password'];
        $user->save();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Account updated !',
        ]);
    }

    public function delete() {
        $user = request()->user();

        if($user->projects()->count() > 0) {
            return redirect()->back()->with('toast', [
                'type' => 'error',
                'message' => 'You can\'t delete your account because you have projects.',
            ]);
        }

        $user->delete();

        return redirect()->route('homepage')->with('toast', [
            'type' => 'success',
            'message' => 'Account deleted !',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function list() {
        $currentUser = auth()->user();
        $users = $currentUser->organization->users()->paginate(10);

        return Inertia::render("Dashboard/Users", [
            'users' => $users,
        ]);
    }

    public function create() {
        $user = auth()->user();
        $password = Str::random(10);

        $data = request()->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required','email:rfc,dns,spoof','max:255', Rule::unique('users')],
        ]);

        User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'organization_id' => $user->organization->id,
            'password' => $password,
        ]);

        // TODO: Send email to user with credentials

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'User created !',
        ]);
    }

    public function delete(User $user) {
        $user->delete();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'User deleted !',
        ]);
    }
}

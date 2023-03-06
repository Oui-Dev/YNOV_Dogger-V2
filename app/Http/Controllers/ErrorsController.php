<?php

namespace App\Http\Controllers;

use App\Mail\ErrorAssignEmail;
use App\Traits\ErrorTrait;
use App\Models\Error;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class ErrorsController extends Controller
{
    use ErrorTrait;

    public function list() {
        $user = auth()->user();
        $errors = Error::whereHas('project', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->with('project')
            ->get();

        return Inertia::render("Dashboard/Errors", [
            'errors' => $errors
        ]);
    }

    public function create() {
        $data = request()->validate([
            'project_id' => ['required', 'integer'],
            'code' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'path' => ['nullable', 'string', 'max:255'],
            'line' => ['nullable', 'string', 'max:255'],
            'timestamp' => ['nullable'],
        ]);

        Error::create([
            'project_id' => $data['project_id'],
            'code' => $data['code'] ?? null,
            'message' => $data['message'] ?? null,
            'path' => $data['path'] ?? null,
            'line' => $data['line'] ?? null,
            'timestamp' => $data['timestamp'] ?? now(),
            'status' => 0,
        ]);

        return response()->json([
            'state' => 'success',
        ]);
    }

    public function updateStatus(Error $error) {
        $this->hasAccess($error->project->user_id);

        $data = request()->validate([
            'status' => ['required', 'integer', 'min:0', 'max:3'],
        ]);

        $error->status = $data['status'];
        $error->save();

        return redirect()->route('dashboard.errors.list')->with('toast', [
            'type' => 'success',
            'message' => 'Error status updated !',
        ]);
    }

    public function assignTo(Error $error) {
        $this->hasAccess($error->project->user_id);

        $data = request()->validate([
            'email' => ['required','email:rfc,dns,spoof','max:255'],
        ]);

        Mail::to($data["email"])->send(new ErrorAssignEmail($error->project->name, $error->message));
        
        $error->assigned_to = $data['email'];
        $error->save();

        return redirect()->route('dashboard.errors.list')->with('toast', [
            'type' => 'success',
            'message' => 'Error assigned to '.$data['email'].' !',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\ErrorAssignEmail;
use App\Traits\ErrorTrait;
use App\Models\Error;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ErrorsController extends Controller
{
    use ErrorTrait;

    public function list() {
        $user = auth()->user();
        $projectFor = Request::get('project');
        if($projectFor === 'All') $projectFor = null;

        if($projectFor) {
            $errors = Error::where('project_id', $projectFor);
        } else {
            $errors = Error::whereHas('project', function($query) use ($user) {
                $query->where('organization_id', $user->organization->id);
            });
        }

        $errors = $errors->orderBy('created_at', 'desc')->with('project')->with('assignedTo')->paginate(10);
        $projects = $user->organization->projects()->get();

        return Inertia::render("Dashboard/Errors", [
            'errors' => $errors,
            'projects' => $projects,
            'users' => $user->organization->users()->get(),
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

    public function update(Error $error) {
        $this->hasAccessToProject($error->project);

        $data = request()->validate([
            'status' => ['required', 'integer', 'min:0', 'max:3'],
            'assigned_to' => ['nullable','integer', Rule::exists('users', 'id')->where(function ($query) use ($error) {
                $query->where('organization_id', $error->project->organization->id);
            })],
        ]);

        if($data['assigned_to'] && $data['assigned_to'] !== $error->assigned_to) {
            $user = User::where('id', $data['assigned_to'])->first();
            Mail::to($user["email"])->send(new ErrorAssignEmail($error->project->name, $error->message));
        }
        
        $error->status = $data['status'];
        $error->assigned_to = $data['assigned_to'];
        $error->save();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Error updated !',
        ]);
    }
}

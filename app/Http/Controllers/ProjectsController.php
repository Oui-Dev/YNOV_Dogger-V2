<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Traits\ErrorTrait;
use App\Models\Project;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    use ErrorTrait;

    public function list() {
        $user = auth()->user();
        $projects = $user->organization->projects()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render("Dashboard/Projects", [
            "projects" => $projects
        ]);
    }

    public function create() {
        $user = auth()->user();

        $data = request()->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('projects')->where(function ($query) {
                return $query->where('user_id', request()->user()->id);
            })], 
        ]);

        Project::create([
            'user_id' => $user->id,
            'name' => $data['name'],
            'key' => bin2hex(random_bytes(16)).'/'.Str::slug($data['name']),
        ]);

        return redirect()->route('dashboard.projects.list')->with('toast', [
            'type' => 'success',
            'message' => 'Project created !',
        ]);
    }

    public function update(Project $project) {
        $this->hasAccess($project->user_id);

        $data = request()->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('projects')->where(function ($query) {
                return $query->where('user_id', request()->user()->id);
            })->ignore($project->id)],
        ]);

        $newKey = str_replace(Str::slug($project->name), Str::slug($data['name']), $project->key);
        $project->name = $data['name'];
        $project->key = $newKey;
        $project->save();

        return redirect()->route('dashboard.projects.list')->with('toast', [
            'type' => 'success',
            'message' => 'Project updated !',
        ]);
    }

    public function delete(Project $project) {
        $this->hasAccess($project->user_id);

        $project->delete();

        return redirect()->route('dashboard.projects.list')->with('toast', [
            'type' => 'success',
            'message' => 'Project deleted !',
        ]);
    }
}

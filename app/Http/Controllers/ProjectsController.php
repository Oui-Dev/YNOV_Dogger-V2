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
            'name' => ['required', 'string', 'max:255', Rule::unique('projects')->where(function ($query) use ($user) {
                return $query->where('organization_id', $user->organization->id);
            })], 
        ]);

        Project::create([
            'name' => $data['name'],
            'key' => bin2hex(random_bytes(16)).'/'.Str::slug($data['name']),
            'organization_id' => $user->organization->id,
        ]);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Project created !',
        ]);
    }

    public function update(Project $project) {
        $user = auth()->user();
        $this->hasAccessToProject($project);

        $data = request()->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('projects')->where(function ($query) use ($user) {
                return $query->where('organization_id', $user->organization->id);
            })->ignore($project->id)],
        ]);

        $newKey = str_replace(Str::slug($project->name), Str::slug($data['name']), $project->key);
        $project->name = $data['name'];
        $project->key = $newKey;
        $project->save();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Project updated !',
        ]);
    }

    public function delete(Project $project) {
        $this->hasAccessToProject($project);

        $project->delete();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Project deleted !',
        ]);
    }
}

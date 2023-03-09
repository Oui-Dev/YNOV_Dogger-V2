<?php

namespace App\Traits;
use App\Models\User;

trait ErrorTrait {
    /**
     * Return error if user is not allowed to access to the ressource
     *
     * @param \App\Models\Project $project
     */
    public function hasAccessToProject($project) {
        $check = User::join('organizations', 'users.id', '=', 'organizations.owner_id')
            ->join('projects', 'organizations.id', '=', 'projects.organization_id')
            ->where('users.id', auth()->user()->id)
            ->where('projects.id', $project->id)
            ->select('users.id')
            ->first();
 
        if(!$check) {
            return redirect()->route('dashboard.index')->with('toast', [
                'type' => 'error',
                'message' => 'You are not allowed to access to this ressource.',
            ]);
        }
        return true;
    }
}

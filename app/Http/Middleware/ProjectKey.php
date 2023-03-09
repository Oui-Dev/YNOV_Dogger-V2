<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Illuminate\Http\Request;
use Closure;

class ProjectKey
{
    public function handle(Request $request, Closure $next)
    {
        $project_key = substr($request->headers->get('Authorization'), 7);
        $project = Project::where('key', $project_key)->first();

        if(!$project) {
            return response()->json([
                'message' => 'Invalid project Key'
            ], 404);
        }

        $request->request->add(['project_id' => $project->id]);
        return $next($request);
    }
}

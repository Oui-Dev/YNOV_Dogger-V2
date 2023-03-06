<?php

namespace App\Traits;

trait ErrorTrait {
    /**
     * Return error if user is not allowed to access to the ressource
     *
     * @param int $id
     */
    public function hasAccess(int $id) {
        if($id !== auth()->user()->id) {
            return redirect()->route('dashboard.index')->with('toast', [
                'type' => 'error',
                'message' => 'You are not allowed to access to this ressource.',
            ]);
        }
        return true;
    }
}

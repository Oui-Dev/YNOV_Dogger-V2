<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'code',
        'message',
        'path',
        'line',
        'status',
        'assigned_to',
        'timestamp',
        'viewed_at',
    ];

    public function project(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedTo(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}

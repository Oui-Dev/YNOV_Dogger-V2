<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'key',
        'organization_id',
    ];

    public function organization(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function errors(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Error::class);
    }
}

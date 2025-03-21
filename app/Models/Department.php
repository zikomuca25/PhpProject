<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'department_id');
    }
    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'department_id');
    }
    


}

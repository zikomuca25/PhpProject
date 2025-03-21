<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'department_id',
        'profile_picture',
        'first_name',
        'last_name',
        'phone',
        'address',
        'admin_level',
        'permissions'
    ];

    protected $casts = [
        'admin_level' => 'integer',
        'permissions' => 'array', // stored as JSON
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}

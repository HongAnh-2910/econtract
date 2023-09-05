<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name_role',
        'id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role');
    }
}

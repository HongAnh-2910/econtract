<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserType extends Model
{
    const TYPE_FREE = 'free';
    const TYPE_PAID = 'paid';

    use SoftDeletes;

    protected $table = 'user_type';

    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'user_type_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscription extends Model
{
    use SoftDeletes;

    public $table = 'user_subscriptions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'user_id',
        'type_id',
        'business_name',
        'business_alias',
        'tax_code',
        'duration_package',
        'last_name',
        'first_middle_name',
        'email',
        'phone_number',
        'birthday',
        'gender',
        'address',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type()
    {
        return $this->belongsTo(UserType::class, 'type_id');
    }
}

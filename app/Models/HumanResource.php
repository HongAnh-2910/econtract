<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HumanResource extends Model
{
    use SoftDeletes;

    public $table = 'human_resource_managers';

    public $fillable = [
        'gender',
        'phone_number',
        'date_start',
        'department_id',
        'form',
        'date_of_birth',
        'passport',
        'date_range',
        'place_range',
        'permanent_address',
        'current_address',
        'account_number',
        'name_account',
        'name_bank',
        'motorcycle_license_plate',
        'file',
        'user_id',
        'user_hrm'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}

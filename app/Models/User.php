<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'img_user',
        'provider',
        'provider_id',
        'user_type_id',
        'parent_id',
        'active',
        'valid_to'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'role_string',
        'avatar_link',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    public function ownerFiles()
    {
        return $this->hasMany(File::class);
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'file_share');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'user_department');
    }

    public function userShareFolders()
    {
        return $this->belongsToMany(Folder::class, 'folder_share');
    }

    public function contract()
    {
        return $this->hasOne(Contract::class, 'user_id');
    }

    public function signatureTemplates()
    {
        return $this->hasMany(SignatureTemplate::class, 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id');
    }

    public function ownerApplication()
    {
        return $this->hasMany(Application::class, 'user_application');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'user_id');
    }

    public function humanResources()
    {
        return $this->hasMany(HumanResource::class, 'user_id');
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }

    public function applicationss()
    {
        return $this->belongsToMany(Application::class, 'consider_applications', 'user_id');
    }

    public function scopeWithoutId($query, $id)
    {
        return $query->where('id', '<>', $id);
    }

    public function getRoleStringAttribute()
    {
        $roleString = '';
        foreach ($this->roles()->get() as $roleItem) {
            $roleString .= $roleItem->name_role;
        }

        return $roleString;
    }

    public function getDepartmentStringAttribute()
    {
        $arrayDepartment = $this->departments()->get();
        $departmentString = '';
        foreach ($arrayDepartment as $key => $item) {
            $departmentString .= (($key + 1) == count($arrayDepartment)) ? $item->name . '' : $item->name . ', ';
        }

        return $departmentString;
    }

    public function getAvatarLinkAttribute()
    {
        if ($this->img_user) {
            return asset('images/avatar/' . $this->img_user);
        } else {
            return asset('images/admin.png');
        }
    }

    /**
     * @param $query
     * @param $userId
     * @return mixed
     */

    public function scopeWhereByParentUser($query , $userId)
    {
        return $query->where('parent_id', $userId);
    }
}

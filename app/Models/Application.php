<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;

    protected $table = 'applications';


    protected $fillable = [
        'code',
        'name',
        'status',
        'reason',
        'application_type',
        'department_id',
        'position',
        'user_id',
        'description',
        'proposal_name',
        'proponent',
        'account_information',
        'files',
        'delivery_date',
        'delivery_time',
        'user_application',
        'price_proposal',
        'created_at'
    ];


    public function dateTimeOfApplications()
    {
        return $this->hasMany(DateTimeOfApplication::class, 'application_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userApplication()
    {
        return $this->belongsTo(User::class, 'user_application');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'consider_applications', 'application_id', 'user_id');
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'file_application', 'application_id', 'file_id');
    }

    public function getCountDay($id)
    {
        $listApplication = $this->where('user_application', $id)->get();
        $count = 0;
        foreach ($listApplication as $value) {
            $countDay = 0;
            foreach ($value->dateTimeOfApplications as $total) {
                $to_date = Carbon::createFromFormat('Y-m-d H:s:i', $total->information_day_2);
                $from_date = Carbon::createFromFormat('Y-m-d H:s:i', $total->information_day_4);
                $countDay += $to_date->diffInDays($from_date);
            }
            $count += $countDay;
        }
        return $count;
    }

    public function totalBackRest($id, $dateStart)
    {
        $getDays = $this->getCountDay($id);
        $monthStart = Carbon::parse($dateStart)->format('m');
        $yearStart = Carbon::parse($dateStart)->format('Y');
        $year = Carbon::now()->year;
        if ($year == $yearStart) {
            $returnStart = (12 - $monthStart) + 1;
            if ($returnStart - $getDays == 0) {
                return '0' . ' ' . 'Ngày';
            } elseif ($returnStart - $getDays < 0) {
                return '0' . ' ' . 'Ngày';
            } else {
                return $returnStart - $getDays . ' ' . 'Ngày';
            }
        } else {
            return 12 - $getDays . ' ' . 'Ngày';
        }
    }

    public function scopeGetByIdApplication($query , $id)
    {
        return $query->where('id', $id);
    }

    /**
     * @param $query
     * @param string $search
     * @return mixed
     */

    public function scopeSearchName($query , string $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }

    /**
     * @param $query
     * @param $search
     * @return mixed
     */

    public function scopeIsSearchName($query , $search)
    {
        if (!empty($search))
        {
            return $query->SearchName($search);
        }
        return $query;
    }

    /**
     * @param $query
     * @param $userId
     * @return mixed
     */

    public function scopeGetUserApplicationOrUser($query , $userId)
    {
       return $query->where(function ($query) use($userId) {
            $query->UserApplication($userId);
            $query->orWhere('user_id' , $userId);
        });
    }

    /**
     * @param $query
     * @param string $status
     * @return mixed
     */
    public function scopeStatusApplication($query , string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * @param $query
     * @param $type
     * @return mixed
     */

    public function scopeTypeApplication($query , $type)
    {
        return $query->where('application_type' ,$type);
    }

    /**
     * @param $query
     * @param $user
     * @return mixed
     */

    public function scopeUserApplication($query, $user)
    {
        return $query->where('user_application' , $user);
    }

}

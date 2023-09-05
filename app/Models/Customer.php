<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';

    public $fillable = [
        'customer_code',
        'name',
        'tax_code',
        'name_company',
        'address',
        'account_number',
        'name_bank',
        'payments',
        'customer_type',
        'phone_number',
        'email',
        'created_at',
        'user_id',
    ];

    const INDIVIDUAL =  'Cá nhân';
    const ENTERPRISE = 'Doanh nghiệp';
    const DELETED = 'deleted';

    public $timestamps = false;

    protected $hidden = ['updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
     * @param string $type
     * @return mixed
     */

    public function scopeTypeCustomer($query , string $type)
    {
        return $query->where('customer_type', $type);
    }

    /**
     * @param $query
     * @param string $search
     * @return mixed
     */
    public function scopeIsSearchName($query , string $search)
    {
        if (!empty($search))
        {
            return $query->SearchName($search);
        }
        return $query;
    }
}

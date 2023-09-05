<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Signatures extends Model
{
    use SoftDeletes;

    protected $table = 'signatures';

    public $timestamps = true;

    protected $fillable = [
        'dataX',
        'dataY',
        'email',
        'path',
        'token',
        'contract_id',
        'id',
        'sign_sequence',
        'name',
        'file_id',
        'signatured_at',
        'mailed_at',
        'client_id'
    ];

    protected $appends = [
        'signature_status',
        'is_signature',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function scopeMailedAtNull($query)
    {
        return $query->where('mailed_at', null);
    }

    public function scopeMailedAtNotNull($query)
    {
        return $query->where('mailed_at', '!=', null);
    }

    public function scopeIsSignatureUsed($query)
    {
        return $query->where('dataX', '!=', null);
    }

    public function getSignatureStatusAttribute()
    {
        if ($this->signatured_at) {
            return 'Đã ký';
        } else {
            return 'Chưa ký';
        }
    }

    public function getIsSignatureAttribute()
    {
        return $this->signatured_at;
    }
}

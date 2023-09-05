<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    use Sluggable;

    public $table = 'contracts';

    protected $fillable = [
        'id',
        'code',
        'sample_contract_id',
        'species_contract',
        'created_contract',
        'code_fax',
        'name',
        'email',
        'name_cty',
        'address',
        'name_customer ',
        'banking_id ',
        'payments',
        'status',
        'user_id',
        'type',
        'slug'
    ];

    protected $appends = [
        'is_mailed',
    ];

    public function banking()
    {
        return $this->belongsTo(Banking::class, 'banking_id');
    }

    public function sampleContract()
    {
        return $this->belongsTo(SampleContract::class, 'sample_contract_id');
    }

    public function recipient()
    {
        return $this->hasMany(ListRecipient::class, 'contract_id');
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'file_contract');
    }

    public function file()
    {
        return $this->hasMany(File::class, 'contract_id');
    }

    public function signatures()
    {
        return $this->hasMany(Signatures::class, 'contract_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function followSignature()
    {
        return $this->hasMany(FollowSignature::class, 'contract_id');
    }

    public function getIsMailedAttribute()
    {
        if ($this->signatures()->where('mailed_at', '!=', null)->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['code', 'name_customer'],
                'onUpdate' => true
            ],

        ];
    }
}

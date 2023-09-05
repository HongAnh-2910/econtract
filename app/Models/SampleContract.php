<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SampleContract extends Model
{
    public $table = 'sample_contract';

    protected $fillable = [
        'id',
        'name_sample_contract'
    ];

    public function contract()
    {
        return $this->hasMany(Contract::class, ' sample_contract_id');
    }
}

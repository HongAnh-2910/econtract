<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListRecipient extends Model
{
    public $table = 'list_recipients';

    protected $fillable = [
        'id',
        'name',
        'signing_sequence',
        'phone',
        'email',
        'contract_id'
    ];

    public function contract()
    {
        return $this->belongsToMany(Contract::class, 'contracts');
    }
}

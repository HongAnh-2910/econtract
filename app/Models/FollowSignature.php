<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowSignature extends Model
{
    protected $fillable = [
        'contract_id',
        'business_name_follow',
        'phone_follow',
        'email_follow',
        'active_screen',
        'token'
    ];

    protected $table = "follow_signatures";

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}

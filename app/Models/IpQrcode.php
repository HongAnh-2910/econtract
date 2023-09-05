<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpQrcode extends Model
{
    public $table = 'ip_qrcode';

    protected $fillable = [
        'ip_network',
        'user_id'
    ];
}

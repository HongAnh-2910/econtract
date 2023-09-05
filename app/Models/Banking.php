<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banking extends Model
{
    protected $table = 'banking';

    protected $fillable = [
        'en_name',
        'vn_name',
        'bankId',
        'atmBin',
        'cardLength',
        'shortName',
        'bankCode',
        'type',
        'napasSupported'
    ];
}

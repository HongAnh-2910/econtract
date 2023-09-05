<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SignatureTemplate extends Model
{
    use SoftDeletes;

    protected $table = 'signature_templates';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'name',
        'signature',
        'user_id',
        'type',
        'path',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

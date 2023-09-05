<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SignatureImage extends Model
{
    use SoftDeletes;

    protected $table = 'signature_images';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'name',
        'path',
        'user_id',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

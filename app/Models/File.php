<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    public $table = 'files';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'name',
        'path',
        'type',
        'size',
        'created_at',
        'updated_at',
        'deleted_at',
        'folder_id',
        'user_id',
        'upload_st',
        'contract_id',
        'file_soft_deleted'
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

    /**
     * @return BelongsToMany
     */
    public function userFile()
    {
        return $this->belongsToMany(User::class, 'file_share')->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */

    public function contracts()
    {
        return $this->belongsToMany(Contract::class, 'file_contract');
    }

    /**
     * @return HasMany
     */
    public function signatures(): HasMany
    {
        return $this->hasMany(Signatures::class, 'file_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}

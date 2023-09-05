<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DateTimeOfApplication extends Model
{
    use SoftDeletes;

    protected $table = 'date_time_of_applications';

    protected $fillable = [
        'information_day_1',
        'information_day_2',
        'information_day_3',
        'information_day_4',
        'application_id'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}

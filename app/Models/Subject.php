<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudyLog;
use App\Models\Field;
use App\Models\Code;

class Subject extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id',
    ];

    public function study_log()
    {
        return $this->hasMany(StudyLog::class);
    }

    public function code()
    {
        return $this->hasMany(Code::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

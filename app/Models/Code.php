<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudyLog;
use App\Models\Subject;

class Code extends Model
{
    // public $timestamps = false;

    protected $guarded = [
        'id',
    ];

    public function study_log()
    {
        return $this->belongsTo(StudyLog::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}

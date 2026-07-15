<?php

namespace App\Models;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Subject;
use App\Models\Code;

class StudyLog extends Model
{
    // use SoftDeletes;
    
    protected $casts = [
        'study_date_time' => 'datetime',
    ];

    protected $guarded = [
        'id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function code()
    {
        return $this->hasMany(Code::class);
    }

    protected function studyTime(): Attribute   //: Attributeは戻り値の型を指定している
    {
        return Attribute::make(
            get: function() {       //名前付き引数
                $hours = (int)floor($this->time / 60);
                $minutes = $this->time % 60;
                if($hours === 0) {
                    return "{$minutes}分";
                } else if($minutes === 0){
                    return "{$hours}時間";
                } else {
                    return "{$hours}時間{$minutes}分";
                }
            }
        );
    }

    protected function formattedStudyDateTime(): Attribute
    {
        return Attribute::make(
            get:function() {
                return $this->study_date_time->isoFormat('Y年MM月DD日 ddd曜日 HH時mm分');
            }
        );
    }

    protected function formattedStudyDateTimeIso(): Attribute
    {
        return Attribute::make(
            get:function() {
                return $this->study_date_time->isoFormat('YYYY-MM-DDTHH:mm');
            }
        );
    }

    protected function getHours(): Attribute
    {
        return Attribute::make(
            get:function() {
                return floor($this->time / 60);
            }
        );
    }

    protected function getMinutes(): Attribute
    {
        return Attribute::make(
            get:function() {
                return $this->time % 60;
            }
        );
    }

    public function todayStudyTime($todayStudyTime)
    {
        $hours = floor($todayStudyTime / 60);
        $minutes = $todayStudyTime % 60;

        if($hours === 0) {
            return "{$minutes}分";
        } else if($minutes === 0){
            return "{$hours}時間";
        } else {
            return "{$hours}時間{$minutes}分";
        }
    }

}

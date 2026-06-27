<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;

class Field extends Model
{
    public $timestamps = false;

    public function subject()
    {
        return $this->hasMany(Subject::class);
    }

}

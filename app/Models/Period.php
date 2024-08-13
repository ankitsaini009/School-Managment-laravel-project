<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TimeTableConfigartion;

class Period extends Model
{
    use HasFactory;

   function periodteacher(){
    return $this->hasMany(TimeTableConfigartion::class,'period_id','id');
    }
}

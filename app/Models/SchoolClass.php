<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;

class SchoolClass extends Model
{
    use HasFactory;
    protected $fillable = ['subjects'];
}

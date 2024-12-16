<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SdgReport extends Model
{
    use HasFactory;

    protected $table = 'sdgreport';

    protected $fillable = [
        'topSdgCourse',
        'department',
        'leastFiveSdgs',
        'sdgResults',
        'currentMonthName'
    ];
}

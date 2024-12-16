<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'uploaded_by',
        'title',
        'project_manager',
        'event_information',
        'photo',
        'sdg_name',
        'comment',
        'attachment',
        'sdg_approved',
        'department',
        'status',
        'date_start',
        'date_end',
    ];
}

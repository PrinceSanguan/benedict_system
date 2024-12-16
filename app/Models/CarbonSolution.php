<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonSolution extends Model
{
    use HasFactory;

    protected $fillable = [
        'carbon_report_id',
        'title',
        'description'
    ];
}

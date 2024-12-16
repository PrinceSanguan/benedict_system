<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_title',
        'supporting_document',
        'calculated_data',
        'comment',
        'fuel_value',
        'fuel_type',
        'fuel_unit',
        'water_value',
        'water_unit',
        'electricity_value',
        'electricity_unit',
        'waste_value',
        'waste_unit'
    ];
}

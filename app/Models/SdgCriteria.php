<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SdgCriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'header_detail_1',
        'detail_1',
        'header_detail_2',
        'detail_2',
        'header_detail_3',
        'detail_3',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonFootprint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'carbon_type',
        'description',
        'attachment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
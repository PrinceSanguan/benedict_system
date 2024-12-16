<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'details',
        'status',
        'submitted_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'location',
        'start_date',
        'end_date',
        'fee',
        'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    public function enrollments()
    {
        return $this->hasMany(EventEnrollment::class);
    }

    public function calendarEntries()
    {
        return $this->hasMany(Calendar::class);
    }
}
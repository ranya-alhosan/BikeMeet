<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'role', 'text', 'status', 'name',
    ];


    public function user()
    {
        return $this->belongsTo(User::class); // Testimonial belongs to one User
    }
}

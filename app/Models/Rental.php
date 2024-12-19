<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{


    use HasFactory;

    protected $fillable = [
        'user_id',
        'motorcycle_id',
        'rental_start_date' ,
        'rental_end_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class);
    }
    public function userRental()
    {
        return $this->hasOne(UserRental::class);
    }

}

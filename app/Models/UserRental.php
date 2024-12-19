<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRental extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'motorcycle_id', 'rent_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class);
    }

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}

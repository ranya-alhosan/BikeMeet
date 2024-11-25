<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function eventEnrollments()
    {
        return $this->hasMany(EventEnrollment::class);
    }

    public function motorcycles()
    {
        return $this->hasMany(Motorcycle::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function newsletterLikes()
    {
        return $this->hasMany(NewsletterLike::class);
    }

    public function newsletterComments()
    {
        return $this->hasMany(NewsletterComment::class);
    }

    public function calendarEntries()
    {
        return $this->hasMany(Calendar::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
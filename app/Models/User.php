<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'country', 'region', 'profile_picture', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Define relationships...
    public function testimonial()
    {
        return $this->hasOne(Testimonial::class);
    }
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
    public function userRentals()
    {
        return $this->hasMany(UserRental::class);
    }
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    public function newsletters()
    {
        return $this->hasMany(Newsletter::class);
    }

    // Cascade delete for related models
    protected static function boot()
    {
        parent::boot();
        static::deleting(function($user) {
            // Delete related records manually
            $user->testimonial()->delete();
            $user->eventEnrollments()->delete();
            $user->motorcycles()->delete();
            $user->rentals()->delete();
            $user->newsletterLikes()->delete();
            $user->newsletterComments()->delete();
            $user->userRentals()->delete();
            $user->events()->delete();
            $user->newsletters()->delete();
        });
    }
}

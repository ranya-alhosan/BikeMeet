<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content'
    ];

    public function likes()
    {
        return $this->hasMany(NewsletterLike::class);
    }

    public function comments()
    {
        return $this->hasMany(NewsletterComment::class);
    }
    
}


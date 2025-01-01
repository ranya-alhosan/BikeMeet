<?php

namespace App\Http\Controllers;
use App\Models\Newsletter;
use App\Models\User;
use App\Models\UserRental;
use Illuminate\Http\Request;
use App\Models\Event;

class ThemeController extends Controller
{

    public function about()
    {
        $events = Event::latest()->take(3)->get();
        $totalUsers = User::count();
        $totalRentals = UserRental::count();
        $totalEvents = Event::count();
        $totalNewsletters = Newsletter::count();
        return view('theme.about', compact('events','totalUsers', 'totalRentals', 'totalEvents', 'totalNewsletters'));
    }

    public function contact(){
        return view('theme.contact');
    }
    public function service(){
        return view('theme.rent');
    }
    public function newsletter(){
        return view('theme.newsletters.newsletter');
    }
    public function testimonial(){
        return view('theme.testimonial');
    }

}

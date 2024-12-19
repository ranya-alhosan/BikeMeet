<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function about(){
        return view('theme.about');
    }
    public function booking(){
        return view('theme.booking');
    }

    public function contact(){
        return view('theme.contact');
    }
    public function service(){
        return view('theme.rent');
    }
    public function team(){
        return view('theme.team');
    }
    public function testimonial(){
        return view('theme.testimonial');
    }

}

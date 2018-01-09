<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  Fetch user id.
        $user_id = auth()->user()->id;

        //  Fetch user with user id.
        $user = User::find($user_id);
    
        //  Load "home"-view and pass on logged in users posts.
        return view('home')->with('posts', $user->posts);
    }
}

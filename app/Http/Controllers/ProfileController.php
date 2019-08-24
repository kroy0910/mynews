<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;
use App\Profile;

class ProfileController extends Controller
{
     public function index(Request $request)
    {
        $prof_data = Profile::all();
        
        return view('profile.index',['prof_data' => $prof_data]);
    }
}

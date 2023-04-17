<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RestController extends Controller
{
    public function index()
    {
        // $user = Auth::user();
        // $user_id = Auth::id();
        // $rests = Rest::where('user_id', $user_id)->get();

        //$param = ['todos' => $todos, 'user' =>$user, 'tags' => $tags];
        // return view('index', compact('todos' , 'user'));
        //return view('index', $param);  
        return view('index');
    }

    public function register()
    {
        // $user = Auth::user();
        // $user_id = Auth::id();
        // $rests = Rest::where('user_id', $user_id)->get();

        // $param = ['rests' => $rests, 'user' =>$user,];
        // return view('index', compact('todos' , 'user'));
        return view('auth.register', $param);
    }

    public function login()
    {
        // $user = Auth::user();
        // $user_id = Auth::id();
        $rests = Rest::where('user_id', $user_id)->get();

        //$param = ['todos' => $todos, 'user' =>$user, 'tags' => $tags];
        // return view('index', compact('todos' , 'user'));
        //return view('index', $param);  
        return view('auth.login');
    }
}

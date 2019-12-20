<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    
    public function logout()
    {
        Auth::logout();
        return redirect("/login");
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // this method show dashboard page
    public function index(){

        return view('dashboard');
        
    }
}

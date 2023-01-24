<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
 
class CheckController extends Controller
{
    public function index() 
    {
        if (!Auth::check()) {
            return false;
        }else{
            return true;
        }
    }
    
}
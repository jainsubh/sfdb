<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(Auth::user()->hasAnyRole('Admin')){
            return redirect()->route('users.index');
        }else if(Auth::user()->hasAnyRole('Manager') || Auth::user()->hasAnyRole('Supervisor')){
            return redirect()->route('manager.index');
        }else if(Auth::user()->hasAnyRole('Analyst')){
            return redirect()->route('analyst.index');
        }
    }
}

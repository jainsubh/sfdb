<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class TwoFactorController extends Controller
{
    public function index() 
    {
        return view('admin::auth.twoFactor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'integer|required',
        ]);

        $user = auth()->user();
        
        if($request->input('two_factor_code') == $user->two_factor_code)
        {
            
            $user->resetTwoFactorCode();
            if(Auth::user()->hasAnyRole('Admin')){
                return redirect()->route('users.index');
            }else if(Auth::user()->hasAnyRole('Manager')){
                return redirect()->route('manager.index');
            }else if(Auth::user()->hasAnyRole('Analyst')){
                return redirect()->route('analyst.index');
            }else if(Auth::user()->hasAnyRole('Supervisor')){
                return redirect()->route('manager.index');
            }
        }

        return redirect()->back()
            ->withErrors(['two_factor_code' => 
                'The two factor code you have entered does not match']);
    }

    public function resend()
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());

        return redirect()->back()->withMessage('The two factor code has been sent again');
    }

    public function cancel()
    {
        $user = auth()->user();
        $user->resetTwoFactorCode();
        session()->flush();
        return redirect()->back()->withMessage('The session is cleared!!');
    }
}
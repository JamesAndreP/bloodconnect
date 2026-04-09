<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing');
    }

    public function hospital()
    {
        $hospitals = Hospital::with(['user'])->get();
        return view('hospital-list')->with([
            'hospitals' => $hospitals,
        ]);
    }
}

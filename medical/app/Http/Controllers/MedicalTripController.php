<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicalTripController extends Controller
{
    public function index()
    {
        return view('medical.travel.index');
    }

    public function travel()
    {
        return view('medical.travel.index');
    }
}

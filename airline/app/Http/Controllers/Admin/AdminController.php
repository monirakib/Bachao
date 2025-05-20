<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Flight;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_flights' => Flight::count(),
            'total_bookings' => Transaction::count(),
            'recent_bookings' => Transaction::with(['user', 'flight'])
                ->latest()
                ->take(5)
                ->get()
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function flights()
    {
        $flights = Flight::orderBy('Start_date')->get();
        return view('admin.flights.index', compact('flights'));
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function bookings()
    {
        $bookings = Transaction::with(['user', 'flight'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }
}
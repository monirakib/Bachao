<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Flight::query();
        
        if ($request->filled(['source', 'destination'])) {
            $query->where('Flight_from', $request->source)
                  ->where('Flight_to', $request->destination);
        }

        $flights = $query->get();
        $sources = Flight::distinct()->pluck('Flight_from');
        $destinations = Flight::distinct()->pluck('Flight_to');

        return view('dashboard', compact('flights', 'sources', 'destinations'));
    }

    public function travelInsurance()
    {
        return view('travel-insurance');
    }

    public function promo()
    {
        $promotions = [
            'BKASH20' => [
                'category' => 'Payment Partner',
                'title' => '20% Off with bKash',
                'description' => 'Save up to 2000৳ on domestic flights',
                'image' => 'bkashs.jpg'
            ],
            'NAGAD15' => [
                'category' => 'Payment Partner',
                'title' => '15% Off with Nagad',
                'description' => 'Save up to 1500৳ on all flights',
                'image' => 'Nagads.jpg'
            ],
            // Add other promotions here...
        ];

        return view('promo', compact('promotions'));
    }

    public function recommend()
    {
        return view('recommend');
    }
}
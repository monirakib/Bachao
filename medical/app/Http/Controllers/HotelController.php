<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::orderBy('rating', 'desc')->get();
        return view('medical.travel.hotels', compact('hotels'));
    }

    public function search(Request $request)
    {
        $query = Hotel::query();

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price_per_night', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_night', '<=', $request->max_price);
        }

        if ($request->has('medical_facilities')) {
            $query->where('has_medical_facilities', true);
        }

        if ($request->has('wheelchair_accessible')) {
            $query->where('wheelchair_accessible', true);
        }

        $hotels = $query->orderBy('rating', 'desc')->get();
        return view('medical.travel.hotels', compact('hotels'));
    }

    public function book(Hotel $hotel)
    {
        return view('medical.travel.hotel-booking', compact('hotel'));
    }

    public function storeBooking(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:4',
            'requirements' => 'nullable|string|max:500'
        ]);

        $booking = $hotel->bookings()->create([
            'user_id' => Auth::id(),
            'check_in' => Carbon::parse($validated['check_in']),
            'check_out' => Carbon::parse($validated['check_out']),
            'guests' => $validated['guests'],
            'requirements' => $validated['requirements'],
            'total_price' => $hotel->price_per_night * Carbon::parse($validated['check_out'])->diffInDays(Carbon::parse($validated['check_in']))
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Hotel booked successfully!');
    }

    public function showBooking(Booking $booking)
    {
        return view('medical.travel.booking-details', compact('booking'));
    }
}
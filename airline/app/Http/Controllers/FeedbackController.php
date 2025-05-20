<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->get();
        $faqs = [
            [
                'question' => 'How can I modify my booking?',
                'answer' => 'You can modify your booking through our website up to 24 hours before departure.'
            ],
            [
                'question' => 'What is the baggage allowance?',
                'answer' => 'Economy class: 20kg, Business class: 30kg'
            ],
            // Add more FAQs as needed
        ];

        return view('feedback.index', compact('feedbacks', 'faqs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'rating' => 'required|integer|between:1,5',
            'comments' => 'required|string|max:1000'
        ]);

        Feedback::create($validated);

        return redirect()->route('feedback')->with('success', 'Thank you for your feedback!');
    }
}
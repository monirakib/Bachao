<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index() {
        $feedbacks = \App\Models\Feedback::orderBy('created_at', 'desc')->get();
        return view('feedback.index', compact('feedbacks'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'feeling' => 'required|integer|min:1|max:5',
                'content' => 'required|string|max:1000',
            ]);

            $feedback = Feedback::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Thank you for your feedback!',
                'feedback' => $feedback
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        }
    }
}

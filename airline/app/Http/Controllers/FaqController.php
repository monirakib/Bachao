<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function suggest(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500'
        ]);

        Faq::create([
            'question' => $validated['question'],
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Thank you for your question! Our team will review it shortly.');
    }
}
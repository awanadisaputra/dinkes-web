<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Honeypot check
        if ($request->filled('website')) {
            return redirect()->back();
        }

        $validatedStats = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Feedback::create($validatedStats);

        return redirect()->back()->with('success', 'Terima kasih atas masukan Anda!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(10);
        return view('dashboard.feedback.index', compact('feedbacks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        if (!$feedback->is_read) {
            $feedback->update(['is_read' => true]);
        }
        return view('dashboard.feedback.show', compact('feedback'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('admin.feedback.index')->with('success', 'Feedback berhasil dihapus');
    }
}

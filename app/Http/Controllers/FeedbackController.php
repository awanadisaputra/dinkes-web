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

        $rules = [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'whatsapp' => 'nullable|string|max:20',
        ];

        if (!$request->has('is_anonymous')) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255';
        }

        $validatedData = $request->validate($rules);

        $validatedData['is_anonymous'] = $request->has('is_anonymous');
        
        if ($validatedData['is_anonymous']) {
            $validatedData['name'] = 'Anonim'; // Or leave null if preferred, but 'Anonim' is display-friendly
             // We can leave email null
        }

        Feedback::create($validatedData);

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

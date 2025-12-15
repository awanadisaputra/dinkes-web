<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $sliders = Slider::when($search, function ($query, $search): void {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('caption', 'like', "%{$search}%");
        })
            ->orderBy('urutan', 'asc')->paginate(10);

        return view('dashboard.slider', compact('sliders', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'caption' => 'required',
            'urutan' => 'required|integer',
            'image' => 'required|image'
        ]);

        $path = $request->file('image')->store('slider', 'public');

        Slider::create([
            'title' => $request->title,
            'caption' => $request->caption,
            'urutan' => $request->urutan,
            'image' => $path,
        ]);

        return redirect()->route('admin.slider.index')->with('success', 'Slider ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required',
            'caption' => 'required',
            'urutan' => 'required|integer',
            'image' => 'nullable|image'
        ]);

        $data = $request->only('title', 'caption', 'urutan');

        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }

            $data['image'] = $request->file('image')->store('slider', 'public');
        }

        $slider->update($data);

        return redirect()->route('admin.slider.index')->with('success', 'Slider diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        if (Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return back()->with('success', 'Slider dihapus');
    }
}

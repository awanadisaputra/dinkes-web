<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::with(['user'])->latest()->get();
        return view('dashboard.announcement.index', compact('announcements'));
    }

    /**
     * Display the specified resource (public view).
     */
    public function show(Announcement $announcement)
    {
        // Only show active announcements to public
        if (!$announcement->is_active) {
            abort(404);
        }
        return view('public.announcement.show', compact('announcement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.announcement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'expires_at' => 'required|date|after_or_equal:today',
        ]);

        $slug = Str::slug($request->title);
        // Ensure slug is unique
        $count = Announcement::where('slug', 'like', $slug . '%')->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        Announcement::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'expires_at' => $request->expires_at,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.announcement.index')->with('success', 'Pengumuman berhasil dibuat');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        return view('dashboard.announcement.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'expires_at' => 'required|date',
        ]);

        if ($request->title !== $announcement->title) {
            $slug = Str::slug($request->title);
            $count = Announcement::where('slug', 'like', $slug . '%')->where('id', '!=', $announcement->id)->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
            $announcement->slug = $slug;
        }



        // Handle image deletion from content
        $oldImages = $this->getImagesFromContent($announcement->content);
        $newImages = $this->getImagesFromContent($request->content);
        $deletedImages = array_diff($oldImages, $newImages);

        foreach ($deletedImages as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }

        $announcement->title = $request->title;
        $announcement->content = $request->content;
        $announcement->expires_at = $request->expires_at;
        $announcement->save();

        return redirect()->route('admin.announcement.index')->with('success', 'Pengumuman berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {


        $images = $this->getImagesFromContent($announcement->content);
        foreach ($images as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }
        $announcement->delete();
        return redirect()->route('admin.announcement.index')->with('success', 'Pengumuman berhasil dihapus');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('announcements/content', 'public');
            return response()->json(['url' => Storage::url($path)]);
        }
        return response()->json(['error' => 'No image uploaded'], 400);
    }

    public function deleteImage(Request $request)
    {
        $url = $request->url;
        if (!$url) {
            return response()->json(['error' => 'No URL provided'], 400);
        }

        $path = str_replace('/storage/', '', $url);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'File not found'], 404);
    }

    private function getImagesFromContent($content)
    {
        $images = [];
        $dom = new \DOMDocument();
        @$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imgTags = $dom->getElementsByTagName('img');

        foreach ($imgTags as $img) {
            $src = $img->getAttribute('src');
            if (strpos($src, '/storage/') !== false) {
                $images[] = str_replace('/storage/', '', $src);
            }
        }
        return $images;
    }
}

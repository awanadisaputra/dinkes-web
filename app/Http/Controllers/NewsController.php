<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::with(['user'])->latest()->get();
        return view('dashboard.news.index', compact('news'));
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news, Request $request)
    {
        // Increment views
        $news->increment('views');

        // Log visit
        $news->visits()->create([
            'ip_address' => $request->ip(),
        ]);

        return view('public.news.show', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
        ]);

        $slug = Str::slug($request->title);
        // Ensure slug is unique
        $count = News::where('slug', 'like', $slug . '%')->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('news/thumbnails', 'public');
        }

        News::create([
            'title' => $request->title,
            'slug' => $slug,
            'thumbnail' => $thumbnailPath,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dibuat');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('dashboard.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
        ]);

        if ($request->title !== $news->title) {
            $slug = Str::slug($request->title);
            $count = News::where('slug', 'like', $slug . '%')->where('id', '!=', $news->id)->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
            $news->slug = $slug;
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($news->thumbnail) {
                Storage::disk('public')->delete($news->thumbnail);
            }
            $news->thumbnail = $request->file('thumbnail')->store('news/thumbnails', 'public');
        }

        // Handle image deletion from content
        $oldImages = $this->getImagesFromContent($news->content);
        $newImages = $this->getImagesFromContent($request->content);
        $deletedImages = array_diff($oldImages, $newImages);

        foreach ($deletedImages as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }

        $news->title = $request->title;
        $news->content = $request->content;
        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
        }

        $images = $this->getImagesFromContent($news->content);
        foreach ($images as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news/content', 'public');
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


    public function uploadVideo(Request $request)
    {
        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('news/videos', 'public');
            return response()->json(['url' => Storage::url($path)]);
        }
        return response()->json(['error' => 'No video uploaded'], 400);
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

<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GuestArticleController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('public.article.guest_create', compact('categories'));
    }

    public function store(Request $request)
    {
        if ($request->filled('address_confirmation')) {
            return redirect()->back()->with('success', 'Artikel Anda telah berhasil diajukan dan sedang menunggu persetujuan admin.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_whatsapp' => 'required|string|max:20',
        ]);

        $slug = Str::slug($request->title);
        $count = Article::where('slug', 'like', $slug . '%')->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('articles/thumbnails', 'public');
        }

        Article::create([
            'title' => $request->title,
            'slug' => $slug,
            'thumbnail' => $thumbnailPath,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'status' => 'pending',
            'is_guest' => true,
            'guest_name' => $request->guest_name,
            'guest_email' => $request->guest_email,
            'guest_whatsapp' => $request->guest_whatsapp,
            'user_id' => null,
        ]);

        return redirect()->back()->with('success', 'Artikel Anda telah berhasil diajukan dan sedang menunggu persetujuan admin.');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles/content', 'public');
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Submenu;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::with(['user'])->latest()->get();
        $menuLinks = Menu::pluck('link')->toArray();
        $submenuLinks = Submenu::pluck('link')->toArray();
        $allLinks = array_merge($menuLinks, $submenuLinks);

        foreach ($pages as $page) {
            $pageUrl = '/page/' . $page->slug;
            $page->is_in_navbar = in_array($pageUrl, $allLinks);
        }

        return view('dashboard.page.index', compact('pages'));
    }

    /**
     * Display the specified resource (public view).
     */
    public function show(Page $page)
    {
        return view('public.page.show', compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug',
            'content' => 'required',
        ]);

        Page::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.page.index')->with('success', 'Halaman berhasil dibuat');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('dashboard.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'required',
        ]);

        // Handle image deletion from content
        $oldImages = $this->getImagesFromContent($page->content);
        $newImages = $this->getImagesFromContent($request->content);
        $deletedImages = array_diff($oldImages, $newImages);

        foreach ($deletedImages as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }

        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->content = $request->content;
        $page->save();

        return redirect()->route('admin.page.index')->with('success', 'Halaman berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $images = $this->getImagesFromContent($page->content);
        foreach ($images as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }
        $page->delete();
        return redirect()->route('admin.page.index')->with('success', 'Halaman berhasil dihapus');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('pages/content', 'public');
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

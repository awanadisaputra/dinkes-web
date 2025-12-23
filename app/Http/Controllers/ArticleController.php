<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Article::with(['user', 'category']);
        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }
        $articles = $query->latest()->get();
        return view('dashboard.article.index', compact('articles'));
    }

    public function publicIndex(Request $request)
    {
        $query = Article::query()->active()->with(['category', 'user']);

        // Filtering by Category
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        // Filtering by Author
        if ($request->has('author')) {
            $user = User::where('username', $request->author)->firstOrFail();
            $query->where('user_id', $user->id);
        }

        // Search
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        if ($sort === 'popular') {
            $query->orderBy('views', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $articles = $query->paginate(9)->withQueryString();
        $categories = Category::withCount('articles')->get();

        return view('public.article.index', compact('articles', 'categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article, Request $request)
    {
        if ($article->status !== 'published' && !Auth::check()) {
            abort(404);
        }

        // Increment views
        $article->increment('views');

        // Log visit
        $article->visits()->create([
            'ip_address' => $request->ip(),
        ]);

        return view('public.article.show', compact('article'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.article.create', compact('categories'));
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
            'category_id' => 'required|exists:categories,id',
        ]);

        $slug = Str::slug($request->title);
        // Ensure slug is unique
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
            'user_id' => Auth::id(),
            'status' => 'published',
            'is_guest' => false,
        ]);

        return redirect()->route('admin.article.index')->with('success', 'Artikel berhasil dibuat');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        if (auth()->user()->role !== 'admin' && $article->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke artikel ini');
        }

        $categories = Category::all();
        return view('dashboard.article.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        if (auth()->user()->role !== 'admin' && $article->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke artikel ini');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->title !== $article->title) {
            $slug = Str::slug($request->title);
            $count = Article::where('slug', 'like', $slug . '%')->where('id', '!=', $article->id)->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
            $article->slug = $slug;
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $article->thumbnail = $request->file('thumbnail')->store('articles/thumbnails', 'public');
        }

        // Handle image deletion from content
        $oldImages = $this->getImagesFromContent($article->content);
        $newImages = $this->getImagesFromContent($request->content);
        $deletedImages = array_diff($oldImages, $newImages);

        foreach ($deletedImages as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }

        $article->title = $request->title;
        $article->content = $request->content;
        $article->category_id = $request->category_id;
        $article->save();

        return redirect()->route('admin.article.index')->with('success', 'Artikel berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if (auth()->user()->role !== 'admin' && $article->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke artikel ini');
        }

        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $images = $this->getImagesFromContent($article->content);
        foreach ($images as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }
        $article->delete();
        return redirect()->back()->with('success', 'Artikel berhasil dihapus');
    }

    public function submissions()
    {
        $articles = Article::with(['category'])->where('status', 'pending')->latest()->get();
        return view('dashboard.article.submissions', compact('articles'));
    }

    public function approve(Article $article)
    {
        $article->update(['status' => 'published']);
        return redirect()->back()->with('success', 'Artikel berhasil diterbitkan');
    }

    public function reject(Article $article)
    {
        $article->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Artikel telah ditolak');
    }

    public function toggleStatus(Article $article)
    {
        if ($article->status === 'published') {
            $article->update(['status' => 'draft']);
            $message = 'Artikel berhasil di-unpublish (Draft)';
        } elseif ($article->status === 'draft') {
            $article->update(['status' => 'published']);
            $message = 'Artikel berhasil dipublish';
        } else {
             return redirect()->back()->with('error', 'Status artikel tidak dapat diubah (Pending/Rejected)');
        }

        return redirect()->back()->with('success', $message);
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


    public function uploadVideo(Request $request)
    {
        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('articles/videos', 'public');
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

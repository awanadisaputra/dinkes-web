@extends('layouts.public')

@section('title', 'Daftar Artikel - Dinas Kesehatan Kota Kediri')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl mb-4">
                Artikel Kesehatan
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-gray-600">
                Temukan berbagai informasi dan edukasi kesehatan terbaru dari Dinas Kesehatan Kota Kediri.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- Filters Sidebar --}}
            <div class="lg:col-span-1 space-y-8">
                {{-- Search --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Cari Artikel</h3>
                    <form action="{{ route('public.article.index') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Ketik kata kunci..." 
                            class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </form>
                </div>

                {{-- Categories --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Kategori</h3>
                    <div class="space-y-2">
                        <a href="{{ route('public.article.index') }}" 
                            class="flex items-center justify-between p-2 rounded-lg transition-colors {{ !request('category') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <span>Semua Kategori</span>
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('public.article.index', ['category' => $category->slug] + request()->except('category', 'page')) }}" 
                                class="flex items-center justify-between p-2 rounded-lg transition-colors {{ request('category') == $category->slug ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <span>{{ $category->name }}</span>
                                <span class="text-xs bg-gray-100 px-2 py-0.5 rounded-full text-gray-500">{{ $category->articles_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-3">
                {{-- Sorting & Meta --}}
                <div class="flex flex-col sm:flex-row items-center justify-between mb-8 gap-4">
                    <p class="text-gray-500 text-sm">
                        Menampilkan <span class="font-semibold text-gray-900">{{ $articles->firstItem() ?? 0 }}-{{ $articles->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-gray-900">{{ $articles->total() }}</span> artikel
                    </p>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-gray-700">Urutkan:</span>
                        <div class="relative inline-block text-left">
                            <form action="{{ url()->current() }}" method="GET" id="sortForm">
                                @foreach(request()->except('sort', 'page') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <select name="sort" onchange="document.getElementById('sortForm').submit()"
                                    class="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 appearance-none shadow-sm cursor-pointer transition-all">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Article Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($articles as $article)
                        <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            {{-- Thumbnail --}}
                            <div class="aspect-video relative overflow-hidden">
                                @if($article->thumbnail)
                                    <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" 
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-blue-50 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4">
                                    <span class="bg-blue-600 text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-lg backdrop-blur-md bg-opacity-90">
                                        {{ $article->category->name }}
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-6 flex flex-col flex-1">
                                <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $article->created_at->format('d M Y') }}
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        {{ number_format($article->views) }}
                                    </span>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 leading-tight group-hover:text-blue-600 transition-colors">
                                    <a href="{{ route('public.article.show', $article) }}">{{ $article->title }}</a>
                                </h2>
                                <p class="text-gray-500 text-sm mb-6 line-clamp-3 leading-relaxed">
                                    {{ Str::limit(strip_tags($article->content), 120) }}
                                </p>
                                <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs uppercase">
                                            {{ substr($article->user->name ?? $article->guest_name ?? 'A', 0, 1) }}
                                        </div>
                                        <a href="{{ $article->user ? route('public.article.index', ['author' => $article->user->username] + request()->except('author', 'page')) : '#' }}" 
                                           class="text-xs font-semibold text-gray-700 hover:text-blue-600 transition-colors">
                                            {{ $article->user->name ?? $article->guest_name ?? 'Administrator' }}
                                        </a>
                                    </div>
                                    <a href="{{ route('public.article.show', $article) }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full py-20 text-center">
                            <div class="bg-white p-12 rounded-3xl shadow-sm inline-block">
                                <svg class="w-20 h-20 text-gray-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum ada artikel</h3>
                                <p class="text-gray-500">Kami belum mempublikasikan artikel pada kategori atau pencarian ini.</p>
                                <a href="{{ route('public.article.index') }}" class="mt-8 inline-block bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">
                                    Lihat Semua Artikel
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-16">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

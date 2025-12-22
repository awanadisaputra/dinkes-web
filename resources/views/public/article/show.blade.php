@extends('layouts.public')

@section('title', $article->title . ' - Dinas Kesehatan Kota Kediri')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            {{-- Image --}}
            @if ($article->thumbnail)
                <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-64 md:h-96 object-cover">
            @endif

            <div class="p-6 md:p-8">
                {{-- Meta --}}
                <div class="flex items-center gap-4 mb-4 text-sm text-gray-500">
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                        {{ $article->category->name }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $article->created_at->format('d M Y') }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $article->user->name ?? $article->guest_name }}
                    </span>
                </div>

                {{-- Title --}}
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                    {{ $article->title }}
                </h1>

                {{-- Content --}}
                <div class="prose prose-lg max-w-none text-gray-700">
                    {!! $article->content !!}
                </div>
                
                {{-- Back Button --}}
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ url('/') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

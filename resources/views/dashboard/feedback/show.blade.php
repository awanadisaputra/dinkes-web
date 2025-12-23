@extends('layouts.dashboard')

@section('title', 'Detail Kritik & Saran')
@section('heading', 'Detail Kritik & Saran')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
            <a href="{{ route('admin.feedback.index') }}" class="text-blue-600 hover:underline flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>

        <div class="border-b pb-4 mb-4">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $feedback->subject }}</h1>
            <div class="flex flex-col md:flex-row md:items-center text-sm text-gray-600 gap-4">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>{{ $feedback->name }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <a href="mailto:{{ $feedback->email }}" class="hover:text-blue-600">{{ $feedback->email }}</a>
                </div>
                @if($feedback->whatsapp)
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <a href="https://wa.me/{{ $feedback->whatsapp }}" target="_blank" class="hover:text-green-600">{{ $feedback->whatsapp }}</a>
                </div>
                @endif
                <div class="text-gray-400">
                    {{ $feedback->created_at->format('d M Y, H:i') }}
                </div>
            </div>
        </div>

        <div class="prose max-w-none text-gray-800">
            {!! nl2br(e($feedback->message)) !!}
        </div>
        
        <div class="mt-8 pt-4 border-t flex justify-end">
             <form action="{{ route('admin.feedback.destroy', $feedback) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Pesan
                </button>
            </form>
        </div>
    </div>
@endsection

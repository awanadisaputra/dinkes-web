@extends('layouts.dashboard')

@section('title', 'Persetujuan Artikel')
@section('heading', 'Persetujuan Artikel')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
            <h2 class="text-xl font-semibold">Daftar Pengajuan Artikel dari Publik</h2>
            <p class="text-gray-600 text-sm">Artikel berikut diajukan oleh masyarakat dan memerlukan tinjauan sebelum diterbitkan.</p>
        </div>

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Detail Pengirim</th>
                        <th scope="col" class="px-6 py-3">Artikel</th>
                        <th scope="col" class="px-6 py-3">Kategori</th>
                        <th scope="col" class="px-6 py-3">Tanggal Pengajuan</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articles as $item)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $item->guest_name }}</div>
                                <div class="text-xs text-gray-500">{{ $item->guest_email }}</div>
                                <div class="text-xs text-green-600">{{ $item->guest_whatsapp }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $item->title }}</div>
                                <a href="{{ route('public.article.show', $item) }}" target="_blank" class="text-blue-600 text-xs hover:underline">Pratinjau Konten</a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ $item->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs">
                                {{ $item->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('admin.article.approve', $item) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-20 h-8 text-white bg-green-600 hover:bg-green-700 rounded-md text-xs font-medium focus:ring-2 focus:ring-green-300">
                                            Terima
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.article.reject', $item) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-20 h-8 text-white bg-yellow-500 hover:bg-yellow-600 rounded-md text-xs font-medium focus:ring-2 focus:ring-yellow-300">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center">Tidak ada pengajuan artikel baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

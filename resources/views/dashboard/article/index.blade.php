@extends('layouts.dashboard')

@section('title', 'Daftar Artikel')
@section('heading', 'Daftar Artikel')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Artikel</h2>
            <a href="{{ route('admin.article.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Tambah Artikel
            </a>
        </div>

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Judul</th>
                        <th scope="col" class="px-6 py-3">Kategori</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Pengirim</th>
                        <th scope="col" class="px-6 py-3">Tanggal Dibuat</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articles as $article)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    @if($article->thumbnail)
                                        <img src="{{ Storage::url($article->thumbnail) }}" class="w-10 h-10 rounded object-cover" alt="Thumb">
                                    @else
                                        <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">?</div>
                                    @endif
                                    {{ $article->title }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">
                                    {{ $article->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($article->status === 'published')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Publish</span>
                                @elseif($article->status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Pending</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($article->is_guest)
                                    <div class="text-xs font-medium text-gray-900">{{ $article->guest_name }}</div>
                                    <div class="text-[10px] text-gray-500">Masyarakat</div>
                                @else
                                    <div class="text-xs font-medium text-gray-900">{{ $article->user->name ?? 'Admin' }}</div>
                                    <div class="text-[10px] text-gray-500">Staff/UPT</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $article->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('public.article.show', $article->slug) }}" 
                                    class="font-medium text-green-600 hover:underline">Lihat</a>
                                <a href="{{ route('admin.article.edit', $article) }}"
                                    class="font-medium text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.article.destroy', $article) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center">Belum ada artikel.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

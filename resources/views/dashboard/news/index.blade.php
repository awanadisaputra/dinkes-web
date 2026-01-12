@extends('layouts.dashboard')

@section('title', 'Daftar Berita')
@section('heading', 'Daftar Berita')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Berita</h2>
            <a href="{{ route('admin.news.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Tambah Berita
            </a>
        </div>



        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Judul</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Penulis</th>
                        <th scope="col" class="px-6 py-3">Tanggal Dibuat</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($news as $item)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    @if($item->thumbnail)
                                        <img src="{{ Storage::url($item->thumbnail) }}" class="w-10 h-10 rounded object-cover" alt="Thumb">
                                    @else
                                        <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">?</div>
                                    @endif
                                    {{ $item->title }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->status === 'published')
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Publish</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->user->name ?? 'Unknown' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('news.show', $item->slug) }}" 
                                    class="font-medium text-green-600 hover:underline">Lihat</a>
                                <a href="{{ route('admin.news.edit', $item) }}"
                                    class="font-medium text-blue-600 hover:underline">Edit</a>
                                

                                <form action="{{ route('admin.news.destroy', $item) }}" method="POST"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center">Belum ada berita.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

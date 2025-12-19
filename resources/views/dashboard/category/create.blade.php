@extends('layouts.dashboard')

@section('title', 'Tambah Kategori')
@section('heading', 'Tambah Kategori')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
        <form action="{{ route('admin.category.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Kategori</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.category.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
            </div>
        </form>
    </div>
@endsection

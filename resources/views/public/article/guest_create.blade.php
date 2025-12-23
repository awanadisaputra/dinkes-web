@extends('layouts.public')

@section('title', 'Ajukan Artikel - Dinas Kesehatan Kota Kediri')

@push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        #editor-container {
            height: 400px;
        }
    </style>
@endpush

@section('content')
<div class="mx-auto px-4 py-8 bg-gray-100">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Ajukan Artikel</h1>
        <p class="text-gray-600 mb-8">Punya informasi menarik atau artikel kesehatan? Ajukan di sini untuk diterbitkan di website Dinas Kesehatan Kota Kediri. Artikel akan direview oleh admin sebelum dipublish.</p>

        @if (session('success'))
            <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('public.article.store') }}" method="POST" enctype="multipart/form-data" id="article-form">
                @csrf
                
                {{-- Honeypot --}}
                <div class="hidden" aria-hidden="true">
                    <input type="text" name="address_confirmation" tabindex="-1" autocomplete="off">
                </div>
                
                <div class="mb-4">
                    <label for="guest_name" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                    <input type="text" id="guest_name" name="guest_name" value="{{ old('guest_name') }}" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('guest_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="guest_email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" id="guest_email" name="guest_email" value="{{ old('guest_email') }}" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        @error('guest_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="guest_whatsapp" class="block mb-2 text-sm font-medium text-gray-900">No. WhatsApp</label>
                        <input type="text" id="guest_whatsapp" name="guest_whatsapp" value="{{ old('guest_whatsapp') }}" required
                            placeholder="08xxxxxxxxxx"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        @error('guest_whatsapp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul Artikel</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                    <select id="category_id" name="category_id" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5">
                        <option value="" class="text-gray-900">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }} class="text-gray-900">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="thumbnail" class="block mb-2 text-sm font-medium text-gray-900">Thumbnail Artikel</label>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-1">
                    <p class="mt-1 text-sm text-gray-500">JPG, PNG, GIF (Max. 2MB). Gambar utama yang muncul di daftar artikel.</p>
                    @error('thumbnail')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Konten Artikel</label>
                    <div id="editor-container"></div>
                    <textarea name="content" id="content" class="hidden">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                        Ajukan Artikel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://unpkg.com/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
    <script>
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                imageResize: {
                    displaySize: true
                },
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        // Set initial content if exists
        quill.root.innerHTML = `{!! old('content') !!}`;


        let sessionUploadedImages = [];

        quill.on('text-change', function(delta, oldDelta, source) {
            if (source === 'user') {
                const currContents = quill.getContents();
                const oldImages = getImagesFromDelta(oldDelta);
                const currImages = getImagesFromDelta(currContents);
                
                const deletedImages = oldImages.filter(img => !currImages.includes(img));
                
                deletedImages.forEach(imgUrl => {
                    if (sessionUploadedImages.includes(imgUrl)) {
                        deleteFromServer(imgUrl);
                    }
                });
            }
        });

        function getImagesFromDelta(delta) {
            return delta.ops
                .filter(op => op.insert && op.insert.image)
                .map(op => op.insert.image);
        }

        function deleteFromServer(url) {
            const fd = new FormData();
            fd.append('url', url);
            fd.append('_token', '{{ csrf_token() }}');

            fetch('{{ route('public.article.deleteImage') }}', {
                method: 'POST',
                body: fd
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    sessionUploadedImages = sessionUploadedImages.filter(img => img !== url);
                    console.log('Image deleted from server:', url);
                }
            })
            .catch(error => console.error('Error deleting image:', error));
        }

        // Custom image upload handler
        quill.getModule('toolbar').addHandler('image', () => {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();

            input.onchange = () => {
                const file = input.files[0];
                if (/^image\//.test(file.type)) {
                    const fd = new FormData();
                    fd.append('image', file);
                    fd.append('_token', '{{ csrf_token() }}');

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '{{ route('public.article.uploadImage') }}', true);
                    
                    xhr.onload = () => {
                        if (xhr.status === 200) {
                            const url = JSON.parse(xhr.responseText).url;
                            sessionUploadedImages.push(url);
                            const range = quill.getSelection();
                            quill.insertEmbed(range.index, 'image', url);
                        }
                    };
                    xhr.send(fd);
                }
            };
        });

        var form = document.querySelector('#article-form');
        form.onsubmit = function() {
            var content = document.querySelector('#content');
            content.value = quill.root.innerHTML;
        };
    </script>
@endpush

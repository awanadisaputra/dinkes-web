@extends('layouts.dashboard')

@section('title', 'Tambah Halaman')
@section('heading', 'Tambah Halaman')

@push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        #editor-container {
            height: 500px;
        }
    </style>
@endpush

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.page.store') }}" method="POST" id="page-form">
            @csrf
            
            <div class="mb-4">
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul Halaman</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="slug" class="block mb-2 text-sm font-medium text-gray-900">Slug / Path</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">
                        /page/
                    </span>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <p class="mt-1 text-sm text-gray-500">Gunakan (-) sebagai pemisah kata. Contoh: visi-misi</p>
                @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-900">Konten</label>
                <div id="editor-container"></div>
                <textarea name="content" id="content" class="hidden">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.page.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://unpkg.com/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
    <script>
        // Auto-generate slug from title
        const titleInput = document.querySelector('#title');
        const slugInput = document.querySelector('#slug');

        titleInput.addEventListener('keyup', function() {
            let title = titleInput.value;
            let slug = title.toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
            slugInput.value = slug;
        });

        // Quill setup
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                imageResize: {
                    displaySize: true
                },
                toolbar: {
                    container: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['link', 'image'],
                        ['clean']
                    ],
                    handlers: {
                        image: imageHandler
                    }
                }
            }
        });


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

            fetch('{{ route('admin.page.deleteImage') }}', {
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

        function imageHandler() {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();

            input.onchange = () => {
                var file = input.files[0];
                if (/^image\//.test(file.type)) {
                    saveToServer(file);
                } else {
                    console.warn('You could only upload images.');
                }
            };
        }

        function saveToServer(file) {
            const fd = new FormData();
            fd.append('image', file);
            fd.append('_token', '{{ csrf_token() }}');

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('admin.page.uploadImage') }}', true);
            
            xhr.onload = () => {
                if (xhr.status === 200) {
                    const url = JSON.parse(xhr.responseText).url;
                    sessionUploadedImages.push(url);
                    insertToEditor(url);
                } else {
                    console.error('Upload failed');
                    alert('Gagal mengupload file');
                }
            };
            xhr.send(fd);
        }

        function insertToEditor(url) {
            const range = quill.getSelection();
            quill.insertEmbed(range.index, 'image', url);
        }

        var form = document.querySelector('#page-form');
        form.onsubmit = function() {
            var content = document.querySelector('#content');
            content.value = quill.root.innerHTML;
        };
    </script>
@endpush

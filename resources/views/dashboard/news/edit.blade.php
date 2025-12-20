@extends('layouts.dashboard')

@section('title', 'Edit Berita')
@section('heading', 'Edit Berita')

@push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        #editor-container {
            height: 400px;
        }
    </style>
@endpush

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" id="news-form">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul Berita</label>
                <input type="text" id="title" name="title" value="{{ old('title', $news->title) }}" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="mb-4">
                <label for="thumbnail" class="block mb-2 text-sm font-medium text-gray-900">Thumbnail (Biarkan kosong jika tidak berubah)</label>
                @if($news->thumbnail)
                    <div class="mb-2">
                        <img src="{{ Storage::url($news->thumbnail) }}" alt="Current Thumbnail" class="h-32 rounded">
                    </div>
                @endif
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                <p class="mt-1 text-sm text-gray-500">JPG, PNG, GIF (Max. 2MB)</p>
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-900">Konten</label>
                <div id="editor-container">{!! old('content', $news->content) !!}</div>
                <textarea name="content" id="content" class="hidden">{{ old('content', $news->content) }}</textarea>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.news.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan Perubahan</button>
            </div>
        </form>
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

            fetch('{{ route('admin.news.deleteImage') }}', {
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
            xhr.open('POST', '{{ route('admin.news.uploadImage') }}', true);
            
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

        var form = document.querySelector('#news-form');
        form.onsubmit = function() {
            var content = document.querySelector('#content');
            content.value = quill.root.innerHTML;
        };
    </script>
@endpush

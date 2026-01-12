@extends('layouts.dashboard')

@section('title', 'Tambah Slider - Dinas Kesehatan Kota Kediri')

@section('heading', 'Tambah Slider')

@section('content')
    <div class="min-h-screen">
        <div class="w-full bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
            <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                <h3 class="text-lg font-medium text-heading">
                    Tambah Slider
                </h3>
            </div>
            
            <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="py-4 md:py-6 flex flex-col gap-4">
                    <!-- Judul -->
                    <div>
                        <label for="title" class="block mb-2.5 text-sm font-medium text-heading">Judul</label>
                        <input type="text" name="title" id="title"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                            placeholder="Judul Slider" required>
                    </div>

                    <!-- Caption -->
                    <div>
                        <label for="caption" class="block mb-2.5 text-sm font-medium text-heading">Caption (Singkat)</label>
                        <input type="text" name="caption" id="caption"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                            placeholder="Deskripsi Singkat" required>
                    </div>

                    <!-- Urutan -->
                    <div>
                        <label for="urutan" class="block mb-2.5 text-sm font-medium text-heading">Urutan</label>
                        <input type="number" name="urutan" id="urutan"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                            placeholder="1" required>
                    </div>

                    <!-- Gambar -->
                    <div>
                        <label class="block mb-2.5 text-sm font-medium text-heading" for="image">Upload Gambar</label>
                        <input
                            class="cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body"
                            id="image" type="file" name="image" required>
                    </div>

                    <!-- Content (Rich Text) -->
                    <div>
                        <label for="content" class="block mb-2.5 text-sm font-medium text-heading">Konten Lengkap</label>
                        <!-- Quill Editor Container -->
                        <div id="editor" class="bg-neutral-secondary-medium border border-default-medium rounded-t-base" style="min-height: 200px;"></div>
                        <!-- Hidden Input -->
                        <input type="hidden" name="content" id="content">
                    </div>
                </div>

                <div class="flex items-center space-x-4 border-t border-default pt-4 md:pt-6">
                    <button type="submit"
                        class="inline-flex items-center text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                        Simpan Slider
                    </button>
                    <a href="{{ route('admin.slider.index') }}"
                        class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Include Quill Styles and Script -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Tulis konten lengkap di sini...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'header': 1 }, { 'header': 2 }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'indent': '-1' }, { 'indent': '+1' }],
                        [{ 'direction': 'rtl' }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'font': [] }],
                        [{ 'align': [] }],
                        ['clean'],
                        ['link', 'image'] // Added image support just in case, though basic image blot is separate
                    ]
                }
            });

            // Update hidden input on change
            quill.on('text-change', function () {
                document.querySelector('#content').value = quill.root.innerHTML;
            });

            // Ensure value is set on submit
            document.querySelector('form').addEventListener('submit', function () {
                document.querySelector('#content').value = quill.root.innerHTML;
            });
        });
    </script>
@endsection

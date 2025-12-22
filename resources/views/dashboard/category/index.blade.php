@extends('layouts.dashboard')

@section('title', 'Daftar Kategori')
@section('heading', 'Daftar Kategori')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Kategori Artikel</h2>
        <button
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            onclick="openCategoryModal('create')">
            Tambah Kategori
        </button>
    </div>

    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Nama Kategori</th>
                    <th scope="col" class="px-6 py-3">Slug</th>
                    <th scope="col" class="px-6 py-3">Jumlah Artikel</th>
                    <th scope="col" class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $category->name }}</td>
                        <td class="px-6 py-4">{{ $category->slug }}</td>
                        <td class="px-6 py-4">{{ $category->articles->count() }}</td>
                        <td class="px-6 py-4 flex gap-2">
                            <button 
                                onclick="openCategoryModal('edit', '{{ $category->id }}', '{{ $category->name }}', '{{ route('admin.category.update', $category) }}')"
                                class="font-medium text-blue-600 hover:underline">Edit</button>
                            <form action="{{ route('admin.category.destroy', $category) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah/Edit --}}
<div id="categoryModal" class="fixed inset-0 flex items-center justify-center bg-gray-950/25 z-50 hidden">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl w-full">
        <h2 id="modalTitle" class="text-xl font-semibold mb-4">Tambah Kategori</h2>
        <form id="categoryForm" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Kategori</label>
                <input type="text" id="categoryName" name="name" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <p id="nameError" class="mt-2 text-sm text-red-600 hidden"></p>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeCategoryModal()"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Batal</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="submitBtn">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCategoryModal(mode, id = null, name = '', url = '') {
    document.getElementById('categoryModal').classList.remove('hidden');
    const form = document.getElementById('categoryForm');
    const modalTitle = document.getElementById('modalTitle');
    const categoryName = document.getElementById('categoryName');

    // hapus input _method sebelumnya jika ada
    const existingMethod = form.querySelector('input[name="_method"]');
    if(existingMethod) existingMethod.remove();

    if(mode === 'create') {
        modalTitle.textContent = 'Tambah Kategori';
        form.action = "{{ route('admin.category.store') }}";
        form.method = 'POST';
        categoryName.value = '';
    } else if(mode === 'edit') {
        modalTitle.textContent = 'Edit Kategori';
        form.action = url; // pakai route update Laravel
        form.method = 'POST';
        categoryName.value = name;

        // tambahkan method PUT
        const inputMethod = document.createElement('input');
        inputMethod.type = 'hidden';
        inputMethod.name = '_method';
        inputMethod.value = 'PUT';
        form.appendChild(inputMethod);
    }
}

function closeCategoryModal() {
    document.getElementById('categoryModal').classList.add('hidden');
}
</script>
@endsection

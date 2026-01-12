@extends('layouts.dashboard')

@section('title', 'Submenu - Dinas Kesehatan Kota Kediri')

@section('heading', 'Submenu')

@section('content')
    <div class="min-h-screen">


        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
            <div class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 p-4">

                <!-- search -->
                <form method="GET" action="{{ route('admin.submenu.index') }}">
                    <div class="relative my-auto">
                        <label for="input-group-1" class="sr-only">Search</label>

                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>

                        <input type="text" id="input-group-1" name="search" value="{{ $search }}"
                            class="block w-full max-w-96 ps-9 pe-3 py-2 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body"
                            placeholder="Search">
                    </div>
                </form>


                <!-- toggle -->
                <div>
                    <button data-modal-target="createModal" data-modal-toggle="createModal"
                        class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none"
                        type="button">
                        Tambah Submenu
                    </button>

                    <!-- modal tambah submenu -->
                    <div id="createModal" tabindex="-1" aria-hidden="true"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <!-- Modal content -->
                            <div
                                class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                                    <h3 class="text-lg font-medium text-heading">
                                        Tambah Submenu
                                    </h3>
                                    <button type="button"
                                        class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                                        data-modal-hide="createModal">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <form action="{{ route('admin.submenu.store') }}" method="POST">
                                    @csrf

                                    <div class="py-4 md:py-6 flex flex-col gap-4">
                                        <div>
                                            <label for="menu_id" class="block mb-2.5 text-sm font-medium text-heading">Menu
                                                Induk</label>
                                            <select name="menu_id" id="menu_id"
                                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs"
                                                required>
                                                <option value="">Pilih Menu</option>
                                                @foreach($menus as $menu)
                                                    <option value="{{ $menu->id }}">{{ $menu->nama_menu }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="nama_submenu"
                                                class="block mb-2.5 text-sm font-medium text-heading">Nama Submenu</label>
                                            <input type="text" name="nama_submenu" id="nama_submenu"
                                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                                placeholder="Data Pasien" required>
                                        </div>
                                        <div>
                                            <label for="urutan"
                                                class="block mb-2.5 text-sm font-medium text-heading">Urutan</label>
                                            <input type="number" name="urutan" id="urutan"
                                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                                placeholder="1" required>
                                        </div>
                                        <div>
                                            <label for="link"
                                                class="block mb-2.5 text-sm font-medium text-heading">Link</label>
                                            <input type="text" name="link" id="link"
                                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                                placeholder="/admin/pasien" required>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4 border-t border-default pt-4 md:pt-6">
                                        <button type="submit"
                                            class="inline-flex items-center  text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                                            Tambah Submenu
                                        </button>
                                        <button data-modal-hide="createModal" type="button"
                                            class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- table -->
            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-t border-default-medium">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">
                            No.
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Nama Submenu
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Menu Induk
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Urutan
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Link
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($submenus as $submenu)
                        <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                            <td class="px-6 py-4 font-semibold">
                                {{ $loop->iteration + ($submenus->currentPage() - 1) * $submenus->perPage() }}.
                            </td>

                            <td class="px-6 py-4">
                                {{ $submenu->nama_submenu }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center bg-brand/10 text-brand text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $submenu->menu->nama_menu ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                {{ $submenu->urutan }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $submenu->link }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <!-- Tombol Edit -->
                                    <button type="button" data-modal-target="editModal-{{ $submenu->id }}"
                                        data-modal-toggle="editModal-{{ $submenu->id }}"
                                        class="font-medium text-fg-brand hover:underline">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <button type="button" data-modal-target="deleteModal-{{ $submenu->id }}"
                                        data-modal-toggle="deleteModal-{{ $submenu->id }}"
                                        class="font-medium text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </div>

                                <!-- Modal Edit -->
                                <div id="editModal-{{ $submenu->id }}" tabindex="-1" aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <div
                                            class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
                                            <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                                                <h3 class="text-lg font-medium text-heading">
                                                    Edit Submenu
                                                </h3>
                                                <button type="button"
                                                    class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                                                    data-modal-hide="editModal-{{ $submenu->id }}">
                                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18 17.94 6M18 18 6.06 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>

                                            <form action="{{ route('admin.submenu.update', $submenu->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="py-4 md:py-6 flex flex-col gap-4">
                                                    <div>
                                                        <label for="menu_id_edit_{{ $submenu->id }}"
                                                            class="block mb-2.5 text-sm font-medium text-heading">Menu
                                                            Induk</label>
                                                        <select name="menu_id" id="menu_id_edit_{{ $submenu->id }}"
                                                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs"
                                                            required>
                                                            <option value="">Pilih Menu</option>
                                                            @foreach($menus as $menu)
                                                                <option value="{{ $menu->id }}" {{ $submenu->menu_id == $menu->id ? 'selected' : '' }}>
                                                                    {{ $menu->nama_menu }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label for="nama_submenu_edit_{{ $submenu->id }}"
                                                            class="block mb-2.5 text-sm font-medium text-heading">Nama
                                                            Submenu</label>
                                                        <input type="text" name="nama_submenu"
                                                            id="nama_submenu_edit_{{ $submenu->id }}"
                                                            value="{{ $submenu->nama_submenu }}"
                                                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                                            placeholder="Data Pasien" required>
                                                    </div>
                                                    <div>
                                                        <label for="urutan_edit_{{ $submenu->id }}"
                                                            class="block mb-2.5 text-sm font-medium text-heading">Urutan</label>
                                                        <input type="number" name="urutan" id="urutan_edit_{{ $submenu->id }}"
                                                            value="{{ $submenu->urutan }}"
                                                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                                            placeholder="1" required>
                                                    </div>
                                                    <div>
                                                        <label for="link_edit_{{ $submenu->id }}"
                                                            class="block mb-2.5 text-sm font-medium text-heading">Link</label>
                                                        <input type="text" name="link" id="link_edit_{{ $submenu->id }}"
                                                            value="{{ $submenu->link }}"
                                                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                                            placeholder="/admin/pasien" required>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-4 border-t border-default pt-4 md:pt-6">
                                                    <button type="submit"
                                                        class="inline-flex items-center text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                                                        Update Submenu
                                                    </button>
                                                    <button data-modal-hide="editModal-{{ $submenu->id }}" type="button"
                                                        class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                                                        Batal
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Delete -->
                                <div id="deleteModal-{{ $submenu->id }}" tabindex="-1"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <div
                                            class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
                                            <button type="button"
                                                class="absolute top-3 end-2.5 text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                data-modal-hide="deleteModal-{{ $submenu->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-4 md:p-5 text-center">
                                                <svg class="mx-auto mb-4 text-body w-12 h-12" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-heading">
                                                    Apakah Anda yakin ingin menghapus submenu <span
                                                        class="font-semibold">{{ $submenu->nama_submenu }}</span>?
                                                </h3>
                                                <form action="{{ route('admin.submenu.destroy', $submenu->id) }}" method="POST"
                                                    class="inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-base text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                        Ya, Hapus
                                                    </button>
                                                </form>
                                                <button data-modal-hide="deleteModal-{{ $submenu->id }}" type="button"
                                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-body focus:outline-none bg-neutral-secondary-medium rounded-base border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:z-10 focus:ring-4 focus:ring-neutral-tertiary">
                                                    Batal
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-6 py-4 text-gray-500">
                                Data submenu belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
            <div class="mt-4 p-4">
                {{ $submenus->links() }}
            </div>
        </div>
    </div>

    <script>
        // Auto hide toast after 3 seconds
        setTimeout(function () {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.style.display = 'none';
            }
        }, 3000);
    </script>
@endsection
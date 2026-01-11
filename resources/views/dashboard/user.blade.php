@extends('layouts.dashboard')

@section('title', 'Manajemen User')

@section('heading', 'User')

@section('content')
    <div class="min-h-screen">
        @if(session('success'))
            <div id="toast-success"
                class="fixed bottom-5 right-5 flex items-center w-full max-w-sm p-4 text-body bg-neutral-primary-soft rounded-base shadow-xs border border-default"
                role="alert">

                <div class="inline-flex items-center justify-center shrink-0 w-7 h-7 text-fg-success bg-success-soft rounded">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 11.917 9.724 16.5 19 7.5" />
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>

                <div class="ms-3 text-sm font-normal">
                    {{ session('success') }}
                </div>

                <button type="button"
                    class="ms-auto flex items-center justify-center text-body hover:text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded text-sm h-8 w-8 focus:outline-none"
                    data-dismiss-target="#toast-success" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                </button>

            </div>
        @endif

        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
            <div class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 p-4">

                <!-- search -->
                <form method="GET" action="{{ route('admin.user.index') }}">
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
                        Tambah User
                    </button>

                    <!-- modal tambah user -->
                    <div id="createModal" tabindex="-1" aria-hidden="true"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <!-- Modal content -->
                            <div
                                class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                                    <h3 class="text-lg font-medium text-heading">
                                        Tambah user
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
                                <form action="{{ route('admin.user.store') }}" method="POST">
                                    @csrf

                                    <div class="py-4 md:py-6 flex flex-col gap-4">
                                        <div>
                                            <label for="name"
                                                class="block mb-2.5 text-sm font-medium text-heading">Nama</label>
                                            <input type="text" name="name" id="name"
                                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                                placeholder="Nama Lengkap" required="">
                                        </div>
                                        <div>
                                            <label for="username"
                                                class="block mb-2.5 text-sm font-medium text-heading">Username</label>
                                            <input type="text" name="username" id="username"
                                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                                placeholder="Username" required="">
                                        </div>
                                        <div>
                                            <label for="password"
                                                class="block mb-2.5 text-sm font-medium text-heading">Password</label>
                                            <input type="password" name="password" id="password"
                                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                                placeholder="Password" required="">
                                        </div>
                                        <div>
                                            <label for="role" class="block mb-2.5 text-sm font-medium text-heading">Role</label>
                                            <select id="role" name="role"
                                                class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                                                <option value="upt">UPT</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="alamat"
                                                class="block mb-2.5 text-sm font-medium text-heading">Alamat</label>
                                            <textarea id="alamat" name="alamat" rows="4"
                                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body"
                                                placeholder="Write your thoughts here..."></textarea>
                                        </div>
                                        <div>
                                            <label for="no_telp" class="block mb-2.5 text-sm font-medium text-heading">No.
                                                Telepon</label>
                                            <input type="number" id="no_telp" name="no_telp"
                                                class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body"
                                                placeholder="0812xxxx" required />
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4 border-t border-default pt-4 md:pt-6">
                                        <button type="submit"
                                            class="inline-flex items-center  text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                                            Tambah User
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
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Username
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                            <td class="px-6 py-4 font-semibold">
                                {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}.
                            </td>

                            <td class="px-6 py-4">
                                {{ $user->name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $user->username }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs bg-brand/10 text-brand">
                                    {{ $user->role }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <!-- Tombol Edit -->
                                    <button type="button" data-modal-target="editModal-{{ $user->id }}"
                                        data-modal-toggle="editModal-{{ $user->id }}"
                                        class="font-medium text-fg-brand hover:underline">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <button type="button" data-modal-target="deleteModal-{{ $user->id }}"
                                        data-modal-toggle="deleteModal-{{ $user->id }}"
                                        class="font-medium text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </div>

                                <!-- Modal Edit -->
                                <div id="editModal-{{ $user->id }}" tabindex="-1" aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <div
                                            class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
                                            <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                                                <h3 class="text-lg font-medium text-heading">
                                                    Edit User
                                                </h3>
                                                <button type="button"
                                                    class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                                                    data-modal-hide="editModal-{{ $user->id }}">
                                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18 17.94 6M18 18 6.06 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>

                                            <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="py-4 md:py-6 flex flex-col gap-4">
                                                    <div>
                                                        <label for="name_edit_{{ $user->id }}"
                                                            class="block mb-2.5 text-sm font-medium text-heading">Nama</label>
                                                        <input type="text" name="name" id="name_edit_{{ $user->id }}"
                                                            value="{{ $user->name }}"
                                                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                                            placeholder="Nama Lengkap" required="">
                                                    </div>
                                                    <div>
                                                        <label for="username_edit_{{ $user->id }}"
                                                            class="block mb-2.5 text-sm font-medium text-heading">Username</label>
                                                        <input type="text" name="username" id="username_edit_{{ $user->id }}"
                                                            value="{{ $user->username }}"
                                                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                                            placeholder="Username" required="">
                                                    </div>
                                                    <div>
                                                        <label for="password_edit_{{ $user->id }}"
                                                            class="block mb-2.5 text-sm font-medium text-heading">Password (Optional)</label>
                                                        <input type="password" name="password" id="password_edit_{{ $user->id }}"
                                                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                                            placeholder="Leave blank to keep current">
                                                    </div>
                                                    <div>
                                                        <label for="role_edit_{{ $user->id }}" class="block mb-2.5 text-sm font-medium text-heading">Role</label>
                                                        <select id="role_edit_{{ $user->id }}" name="role"
                                                            class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                                                            <option value="upt" {{ $user->role == 'upt' ? 'selected' : '' }}>UPT</option>
                                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label for="alamat_edit_{{ $user->id }}"
                                                            class="block mb-2.5 text-sm font-medium text-heading">Alamat</label>
                                                        <textarea id="alamat_edit_{{ $user->id }}" name="alamat" rows="4"
                                                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body"
                                                            placeholder="Alamat">{{ $user->alamat }}</textarea>
                                                    </div>
                                                    <div>
                                                        <label for="no_telp_edit_{{ $user->id }}" class="block mb-2.5 text-sm font-medium text-heading">No.
                                                            Telepon</label>
                                                        <input type="number" name="no_telp" id="no_telp_edit_{{ $user->id }}"
                                                            value="{{ $user->no_telp }}"
                                                            class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body"
                                                            placeholder="No Telepon" />
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-4 border-t border-default pt-4 md:pt-6">
                                                    <button type="submit"
                                                        class="inline-flex items-center text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                                                        Update user
                                                    </button>
                                                    <button data-modal-hide="editModal-{{ $user->id }}" type="button"
                                                        class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                                                        Batal
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Delete -->
                                <div id="deleteModal-{{ $user->id }}" tabindex="-1"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <div
                                            class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
                                            <button type="button"
                                                class="absolute top-3 end-2.5 text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                data-modal-hide="deleteModal-{{ $user->id }}">
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
                                                    Apakah Anda yakin ingin menghapus user <span
                                                        class="font-semibold">{{ $user->name }}</span>?
                                                </h3>
                                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-base text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                        Ya, Hapus
                                                    </button>
                                                </form>
                                                <button data-modal-hide="deleteModal-{{ $user->id }}" type="button"
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
                            <td colspan="5" class="text-center px-6 py-4 text-gray-500">
                                Data user belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
            <div class="mt-4">
                {{ $users->links() }}
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
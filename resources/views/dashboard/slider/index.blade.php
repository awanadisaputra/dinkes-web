@extends('layouts.dashboard')

@section('title', 'Admin Slider - Dinas Kesehatan Kota Kediri')

@section('heading', 'Slider')

@section('content')
    <div class="min-h-screen">


        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
            <div class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 p-4">

                <!-- search -->
                <form method="GET" action="{{ route('admin.slider.index') }}">
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
                    <a href="{{ route('admin.slider.create') }}"
                        class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none block">
                        Tambah Slider
                    </a>
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
                            Gambar
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Urutan
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Judul
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Caption
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sliders as $slider)
                        <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                            <td class="px-6 py-4 font-semibold">
                                {{ $loop->iteration + ($sliders->currentPage() - 1) * $sliders->perPage() }}.
                            </td>

                            <td class="px-6 py-4">
                                <img src="{{ asset('storage/' . $slider->image) }}" class="w-16 md:w-24 max-w-full max-h-full" alt="{{ $slider->title }}">
                            </td>

                            <td class="px-6 py-4">
                                {{ $slider->urutan }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $slider->title }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $slider->caption }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.slider.edit', $slider->id) }}"
                                        class="font-medium text-fg-brand hover:underline">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.slider.destroy', $slider->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-6 py-4 text-gray-500">
                                Data slider belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
            <div class="mt-4">
                {{ $sliders->links() }}
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

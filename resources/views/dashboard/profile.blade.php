@extends('layouts.dashboard')

@section('title', 'Profil Saya')
@section('heading', 'Profil Saya')

@section('content')
<div class="min-h-screen flex justify-center items-start">

    <div class="w-full max-w-lg bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
            <h3 class="text-lg font-medium text-heading">
                Update Profil
            </h3>
        </div>

        {{-- Notifikasi Sukses --}}


        {{-- Form --}}
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="py-4 md:py-6 flex flex-col gap-4">

                {{-- Nama --}}
                <div>
                    <label for="name" class="block mb-2.5 text-sm font-medium text-heading">
                        Nama Lengkap
                    </label>
                    <input type="text" name="name" id="name"
                        value="{{ old('name', auth()->user()->name) }}"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                        required>
                    @error('name')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Username --}}
                <div>
                    <label for="username" class="block mb-2.5 text-sm font-medium text-heading">
                        Username
                    </label>
                    <input type="text" name="username" id="username"
                        value="{{ old('username', auth()->user()->username) }}"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                        required>
                    @error('username')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div>
                    <label for="alamat" class="block mb-2.5 text-sm font-medium text-heading">
                        Alamat
                    </label>
                    <textarea name="alamat" id="alamat" rows="3"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">{{ old('alamat', auth()->user()->alamat) }}</textarea>
                    @error('alamat')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- No Telp --}}
                <div>
                    <label for="no_telp" class="block mb-2.5 text-sm font-medium text-heading">
                        No. Telepon
                    </label>
                    <input type="text" name="no_telp" id="no_telp"
                        value="{{ old('no_telp', auth()->user()->no_telp) }}"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">
                    @error('no_telp')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Foto Profil --}}
                <div>
                    <label for="avatar" class="block mb-2.5 text-sm font-medium text-heading">
                        Foto Profil
                    </label>
                    <input type="file" name="avatar" id="avatar"
                        class="cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body">
                    @error('avatar')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end border-t border-default pt-4 md:pt-6">
                <button type="submit"
                    class="inline-flex items-center text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                    Update Profil
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Auto hide notification --}}
<script>
    setTimeout(() => {
        document.getElementById('toast-success')?.remove();
    }, 3000);
</script>
@endsection

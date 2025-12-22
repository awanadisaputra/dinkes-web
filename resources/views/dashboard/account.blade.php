@extends('layouts.dashboard')

@section('title', 'Account Settings')
@section('heading', 'Account Settings')

@section('content')
<div class="min-h-screen flex justify-center items-start">

    <div class="w-full max-w-lg bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
            <h3 class="text-lg font-medium text-heading">
                Ubah Password
            </h3>
        </div>

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div id="toast-success"
                class="mt-4 w-full p-4 bg-green-100 border border-green-400 rounded-lg shadow">
                <div class="text-sm font-normal text-green-800">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.account.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="py-4 md:py-6 flex flex-col gap-4">

                {{-- Password Lama --}}
                <div>
                    <label for="current_password" class="block mb-2.5 text-sm font-medium text-heading">
                        Password Lama
                    </label>
                    <input type="password" name="current_password" id="current_password"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                        placeholder="Masukkan password lama" required>
                    @error('current_password')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div>
                    <label for="password" class="block mb-2.5 text-sm font-medium text-heading">
                        Password Baru
                    </label>
                    <input type="password" name="password" id="password"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                        placeholder="Masukkan password baru" required>
                    @error('password')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Konfirmasi Password Baru --}}
                <div>
                    <label for="password_confirmation" class="block mb-2.5 text-sm font-medium text-heading">
                        Konfirmasi Password Baru
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                        placeholder="Ulangi password baru" required>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end border-t border-default pt-4 md:pt-6">
                <button type="submit"
                    class="inline-flex items-center text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                    Update Password
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

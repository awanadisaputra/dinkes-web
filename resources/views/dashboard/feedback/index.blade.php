@extends('layouts.dashboard')

@section('title', 'Kritik & Saran')
@section('heading', 'Kritik & Saran')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="overflow-x-auto relative">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">Nama Pengirim</th>
                        <th scope="col" class="py-3 px-6">Kontak</th>
                        <th scope="col" class="py-3 px-6">Subjek</th>
                        <th scope="col" class="py-3 px-6">Tanggal</th>
                        <th scope="col" class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $feedback)
                        <tr class="bg-white border-b hover:bg-gray-50 {{ !$feedback->is_read ? 'font-bold bg-blue-50' : '' }}">
                            <td class="py-4 px-6 text-gray-900">
                                {{ $feedback->name }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col text-sm">
                                    <span class="text-gray-900">{{ $feedback->email }}</span>
                                    @if($feedback->whatsapp)
                                        <span class="text-gray-500 text-xs">{{ $feedback->whatsapp }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                {{ $feedback->subject }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                {{ $feedback->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="py-4 px-6 flex gap-2">
                                <a href="{{ route('admin.feedback.show', $feedback) }}" class="font-medium text-blue-600 hover:underline">Lihat</a>
                                <form action="{{ route('admin.feedback.destroy', $feedback) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 px-6 text-center text-gray-500">Belum ada kritik dan saran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $feedbacks->links() }}
        </div>
    </div>
@endsection

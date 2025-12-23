@props(['announcements'])

@if($announcements->isNotEmpty())
    <div class="max-w-7xl mx-auto px-4 mt-8 space-y-4 animate-fade-in-down">
        @foreach($announcements as $announcement)
            <div id="announcement-{{ $announcement->id }}" class="relative bg-yellow-50 border border-yellow-200 rounded-2xl p-4 shadow-sm flex items-start justify-between" role="alert">
                <div class="flex items-start">
                    <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-600 rounded-lg mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    </span>
                    <div>
                        <h4 class="font-bold text-yellow-900 text-md mb-1">
                            <a href="{{ route('announcement.show', $announcement->slug) }}" class="hover:underline">
                                {{ $announcement->title }}
                            </a>
                        </h4>
                        <p class="text-yellow-800 text-sm line-clamp-2 mb-2">
                            {{ Str::limit(strip_tags($announcement->content), 200) }}
                        </p>
                        <div class="flex items-center text-xs text-yellow-600 font-medium">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Berlaku sampai: {{ $announcement->expires_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
                
                <button type="button" class="flex-shrink-0 text-yellow-400 bg-transparent hover:bg-yellow-100 hover:text-yellow-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center ml-auto" data-dismiss-target="#announcement-{{ $announcement->id }}" aria-label="Close">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endforeach
    </div>
@endif

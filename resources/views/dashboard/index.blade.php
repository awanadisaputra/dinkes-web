@extends('layouts.dashboard')

@section('title', 'Beranda - Dinas Kesehatan Kota Kediri')

@section('heading', 'Analitik Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Section 1: Top Stats Cards with Gradient -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Menambahkan gradien biru yang lebih menarik dengan animasi hover --}}
        {{-- Total Artikel --}}
        <div class="relative overflow-hidden p-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg transition-all hover:shadow-2xl hover:scale-105 group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150"></div>
            <div class="relative flex items-center space-x-4">
                <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <div class="text-white">
                    <p class="text-sm font-medium text-blue-100">Total Artikel</p>
                    <h3 class="text-4xl font-bold">{{ number_format($totalArticles) }}</h3>
                </div>
            </div>
        </div>

        {{-- Menambahkan gradien hijau emerald yang lebih menarik dengan animasi hover --}}
        {{-- Total Berita --}}
        <div class="relative overflow-hidden p-6 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg transition-all hover:shadow-2xl hover:scale-105 group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150"></div>
            <div class="relative flex items-center space-x-4">
                <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h8M11 12h8M11 19h8M5 5h1v1H5V5zm0 7h1v1H5v-1zm0 7h1v1H5v-1z" />
                    </svg>
                </div>
                <div class="text-white">
                    <p class="text-sm font-medium text-emerald-100">Total Berita</p>
                    <h3 class="text-4xl font-bold">{{ number_format($totalNews) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Monthly Reader Trends Chart -->
    {{-- Memperbaiki header chart dengan warna yang lebih menarik --}}
    <div class="p-6 bg-white rounded-2xl shadow-lg border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Tren Kunjungan Bulanan</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Periode 12 Bulan Terakhir</p>
            </div>
            <div class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold dark:bg-blue-900/30 dark:text-blue-400">
                Real-time Data
            </div>
        </div>
        <div id="viewsChart"></div>
    </div>

    <!-- Section 3: Detailed Content Tables -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Artikel Terpopuler -->
        {{-- Menambahkan shadow dan border yang lebih menonjol untuk tabel --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-blue-100/50 dark:from-blue-900/20 dark:to-blue-900/10">
                <h4 class="text-lg font-bold text-blue-900 dark:text-blue-300 flex items-center">
                    <div class="p-2 bg-blue-500 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    Artikel Terpopuler
                </h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Judul Artikel</th>
                            <th scope="col" class="px-6 py-4 text-center font-semibold">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($popularArticles as $article)
                        <tr class="hover:bg-blue-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white truncate max-w-xs">{{ $article->title }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 text-sm font-bold text-blue-700 bg-blue-100 rounded-lg dark:text-blue-300 dark:bg-blue-900/50">
                                    {{ number_format($article->views) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-12 text-center text-gray-400 italic">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Belum ada data artikel.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Berita Terpopuler -->
        {{-- Menambahkan shadow dan border yang lebih menonjol untuk tabel berita --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-emerald-100/50 dark:from-emerald-900/20 dark:to-emerald-900/10">
                <h4 class="text-lg font-bold text-emerald-900 dark:text-emerald-300 flex items-center">
                    <div class="p-2 bg-emerald-500 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2" /></svg>
                    </div>
                    Berita Terpopuler
                </h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Judul Berita</th>
                            <th scope="col" class="px-6 py-4 text-center font-semibold">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($popularNews as $news_item)
                        <tr class="hover:bg-emerald-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white truncate max-w-xs">{{ $news_item->title }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 text-sm font-bold text-emerald-700 bg-emerald-100 rounded-lg dark:text-emerald-300 dark:bg-emerald-900/50">
                                    {{ number_format($news_item->views) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-12 text-center text-gray-400 italic">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2" />
                                </svg>
                                Belum ada data berita.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Section 4: Active Announcements -->
    {{-- Memperbaiki tampilan tabel pengumuman dengan warna dan shadow yang lebih menarik --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-amber-50 to-amber-100/50 dark:from-amber-900/20 dark:to-amber-900/10">
            <h4 class="text-lg font-bold text-amber-900 dark:text-amber-300 flex items-center">
                <div class="p-2 bg-amber-500 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                Pengumuman Aktif
            </h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">Judul Pengumuman</th>
                        <th scope="col" class="px-6 py-4 text-center font-semibold">Deadline</th>
                        <th scope="col" class="px-6 py-4 text-center font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($announcements as $announcement)
                    <tr class="hover:bg-amber-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $announcement->title }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-gray-700 dark:text-gray-300 font-medium text-sm">
                                {{ \Carbon\Carbon::parse($announcement->expires_at)->format('d M Y') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php $daysLeft = now()->diffInDays($announcement->expires_at, false); @endphp
                            @if($daysLeft <= 3)
                                <span class="px-3 py-1.5 text-xs font-bold text-red-700 bg-red-100 rounded-lg dark:text-red-300 dark:bg-red-900/50">Segera Berakhir</span>
                            @else
                                <span class="px-3 py-1.5 text-xs font-bold text-emerald-700 bg-emerald-100 rounded-lg dark:text-emerald-300 dark:bg-emerald-900/50">Aktif</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-400 italic">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Tidak ada pengumuman aktif saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        series: [{
            name: 'Total Kunjungan',
            data: @json($chartData)
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: { show: false },
            zoom: { enabled: false },
            fontFamily: 'inherit',
        },
        colors: ['#3B82F6'],
        dataLabels: { 
            enabled: false 
        },
        stroke: { 
            curve: 'smooth', 
            width: 3 
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.6,
                opacityTo: 0.1,
                stops: [0, 90, 100]
            }
        },
        grid: {
            borderColor: '#e5e7eb',
            strokeDashArray: 4,
            xaxis: {
                lines: { show: false }
            },
            yaxis: {
                lines: { show: true }
            },
            padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 10
            }
        },
        xaxis: {
            categories: @json($chartLabels),
            labels: {
                style: {
                    colors: '#6b7280',
                    fontSize: '12px',
                    fontWeight: 500,
                }
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#6b7280',
                    fontSize: '12px',
                    fontWeight: 500,
                },
                formatter: function (value) {
                    return value.toLocaleString('id-ID');
                }
            }
        },
        tooltip: {
            x: { 
                format: 'MMMM yyyy' 
            },
            y: {
                formatter: function (value) {
                    return value.toLocaleString('id-ID') + ' views';
                }
            },
            theme: 'light',
            style: {
                fontSize: '12px',
            }
        },
        noData: {
            text: 'Belum ada data kunjungan...',
            align: 'center',
            verticalAlign: 'middle',
            offsetX: 0,
            offsetY: 0,
            style: {
                color: '#9ca3af',
                fontSize: '14px',
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#viewsChart"), options);
    chart.render();
</script>
@endpush

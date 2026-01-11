@props(['sliders' => []])

<section
    style="background-image: url('{{ asset('storage/images/jumbotron.jpeg') }}')"
    class="relative bg-center bg-cover bg-no-repeat bg-dark/90 bg-blend-multiply overflow-hidden pt-24 pb-32 lg:pt-36 lg:pb-48">
    <div class="px-4 mx-auto max-w-7xl text-center relative z-10">
        <h1 class="mb-6 text-4xl font-extrabold tracking-tight text-white md:text-5xl lg:text-7xl">
            Solusi Kesehatan Terpadu untuk Masyarakat
        </h1>
        <p class="mb-10 text-lg font-normal text-gray-200 md:text-xl sm:px-16 lg:px-48">
            Dinas Kesehatan berkomitmen memberikan pelayanan prima melalui inovasi teknologi dan aksesibilitas informasi
            yang mudah bagi seluruh warga.
        </p>

        @if(count($sliders) > 0)
            <div
                class="mt-12 max-w-5xl mx-auto backdrop-blur-sm bg-white/5 p-2 rounded-3xl border border-white/10 shadow-2xl">
                <x-slider :sliders="$sliders" />
            </div>
        @endif
    </div>

    <!-- Gentle Curve -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
        <svg class="relative block w-full h-[50px] md:h-20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
            preserveAspectRatio="none">
            <path d="M0,0 Q600,100 1200,0 L1200,120 L0,120 Z" class="fill-neutral-primary"></path>
        </svg>
    </div>
</section>
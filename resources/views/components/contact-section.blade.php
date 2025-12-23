<div class="max-w-7xl mx-auto px-4 py-12 md:py-20 animate-fade-in-up">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24 items-start">
        
        <!-- Map Section -->
        <div class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold text-heading tracking-tight border-l-4 border-brand pl-4 mb-2">Lokasi Kami</h2>
                <p class="text-body-subtle pl-5">Kunjungi kantor kami atau hubungi melalui kontak yang tersedia.</p>
            </div>
            
            <div class="relative w-full h-[400px] bg-neutral-100 rounded-3xl overflow-hidden shadow-lg border border-default/50 group mb-6">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.923769992686!2d111.992226!3d-7.801648999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78572111100001%3A0xb6f0376135293233!2sDinas%20Kesehatan%20Kota%20Kediri!5e0!3m2!1sid!2sid!4v1709623456789!5m2!1sid!2sid" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    class="absolute inset-0 transition-all duration-700">
                </iframe>
            </div>

            <!-- Address Info Card -->
            <div class="bg-white p-4 rounded-2xl border border-default/50 shadow-sm flex items-start space-x-3">
                <div class="bg-brand/10 p-2 rounded-lg text-brand">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div>
                     <h4 class="font-bold text-heading text-base">Dinas Kesehatan Kota Kediri</h4>
                     <p class="text-sm text-body-subtle mt-0.5 leading-snug">Jl. Mayor Bismo No.15, Semampir, Kota Kediri, Jawa Timur</p>
                </div>
            </div>
        </div>

        <!-- Contact Form Section -->
        <div class="bg-white rounded-3xl p-8 lg:p-10 border border-default/50 shadow-xl shadow-brand/5 relative overflow-hidden">
            <!-- Decorative Background -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-brand/5 to-transparent rounded-bl-full -mr-16 -mt-16 pointer-events-none"></div>
            
            <div class="relative">
                <h2 class="text-3xl font-bold text-heading tracking-tight mb-2">Kritik & Saran</h2>
                <p class="text-body-subtle mb-8">Masukan Anda sangat berharga untuk peningkatan pelayanan kami.</p>

                <form action="{{ route('feedback.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <!-- Honeypot Field -->
                    <input type="text" name="website" style="display:none;">

                    @if(session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                            <span class="font-medium">Berhasil!</span> {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-heading">Nama Lengkap</label>
                        <input type="text" id="name" name="name" required class="bg-neutral-50 border border-default text-heading text-sm rounded-xl focus:ring-brand focus:border-brand block w-full p-3 transition-colors" placeholder="Masukkan nama anda">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-heading">Email</label>
                            <input type="email" id="email" name="email" required class="bg-neutral-50 border border-default text-heading text-sm rounded-xl focus:ring-brand focus:border-brand block w-full p-3 transition-colors" placeholder="nama@email.com">
                        </div>
                        <div>
                            <label for="whatsapp" class="block mb-2 text-sm font-medium text-heading">No. WhatsApp</label>
                            <input type="text" id="whatsapp" name="whatsapp" class="bg-neutral-50 border border-default text-heading text-sm rounded-xl focus:ring-brand focus:border-brand block w-full p-3 transition-colors" placeholder="0812xxxx">
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block mb-2 text-sm font-medium text-heading">Subjek</label>
                        <select id="subject" name="subject" required class="bg-neutral-50 border border-default text-heading text-sm rounded-xl focus:ring-brand focus:border-brand block w-full p-3 transition-colors">
                            <option value="" selected disabled>Pilih kategori masukan</option>
                            <option value="layanan">Pelayanan</option>
                            <option value="fasilitas">Fasilitas</option>
                            <option value="informasi">Informasi/Website</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block mb-2 text-sm font-medium text-heading">Pesan</label>
                        <textarea id="message" name="message" required rows="4" class="bg-neutral-50 border border-default text-heading text-sm rounded-xl focus:ring-brand focus:border-brand block w-full p-3 transition-colors resize-none" placeholder="Tuliskan kritik dan saran anda secara detail..."></textarea>
                    </div>

                    <button type="submit" class="w-full text-white bg-brand hover:bg-brand-strong focus:ring-4 focus:ring-brand/20 font-bold rounded-xl text-sm px-5 py-3.5 text-center transition-all duration-300 shadow-md shadow-brand/20 hover:shadow-lg hover:shadow-brand/30 transform hover:-translate-y-0.5">
                        Kirim Masukan
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

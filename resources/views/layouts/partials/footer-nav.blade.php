<div style="margin-bottom: 5rem"></div>
<footer class="fixed bottom-0 left-0 right-0 bg-white shadow-lg z-50">
    <nav class="flex justify-around items-center h-16 text-gray-500">
        {{-- Tautan Beranda --}}
        <a href="{{ route('home') }}" class="flex flex-col items-center
            {{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-500' }}"
            aria-label="Beranda">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
            </svg>
            <span class="text-xs mt-1 font-bold">Beranda</span>
        </a>

        {{-- Tautan Pengajuan --}}
        <a href="{{ route('tracking.index') }}" id="pengajuan-link" class="flex flex-col items-center
            {{ request()->routeIs('tracking.index') ? 'text-blue-600' : 'text-gray-500' }}"
            aria-label="Lacak Permohonan">

            {{-- Bungkus ikon SVG dalam div.relative agar badge bisa posisi absolut terhadapnya --}}
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                </svg>

                <!-- {{-- Badge notifikasi --}} 
                @if(session('has_unread_status'))
                    <span class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-600 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center z-10">•</span>
                    {{ session('unread_count') }}
                @endif -->
                {{-- Notifikasi Badge dengan Angka --}}
                @if(session('unread_count', 0) > 0)
                    <span class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-600 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center z-10">
                        {{ session('unread_count') }}
                    </span>
                @endif
            </div>

            <span class="text-xs mt-1 font-bold">Lacak</span>
        </a>

        {{-- Logo di tengah --}}
        {{-- <a href="#" class="flex flex-col items-center -mt-1 rounded-full w-9 h-9 shadow-md justify-center">
            <img src="{{ asset('icon/logo2.png') }}" alt="Logo" class="size-8">
        </a> --}}

        {{-- ⭐️ Logo di tengah: MODIFIKASI DIMULAI DI SINI ⭐️ --}}
        <a href="#" class="flex flex-col items-center 
            bg-white 
            -mt-8           /* Menarik ke atas */
            w-16 h-16       /* MEMBESARKAN lingkaran (width dan height) */
            rounded-full 
            shadow-xl       /* Mempertebal bayangan untuk efek 3D */
            justify-center
            p-0.5             /* Menambah sedikit padding */
        ">
            <img src="{{ asset('icon/logo4.png') }}" alt="Logo" class="size-16"> </a>
        {{-- ⭐️ MODIFIKASI SELESAI ⭐️ --}}

        {{-- Tautan Riwayat --}}
        {{-- <a href="{{ route('transaksi.index') }}" id="riwayat-link" class="flex flex-col items-center
            {{ request()->routeIs('transaksi.index') ? 'text-blue-600' : 'text-gray-500' }}" 
            aria-label="Riwayat"> --}}
        <a href="{{ route('home') }}" class="flex flex-col items-center
            {{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-500' }}"
            aria-label="Beranda">    
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.409 1.025 4.587 2.674 6.192.232.226.277.428.254.543a3.73 3.73 0 0 1-.814 1.686.75.75 0 0 0 .44 1.223ZM8.25 10.875a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25ZM10.875 12a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm4.875-1.125a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z" clip-rule="evenodd" />
            </svg>
            <span class="text-xs mt-1 font-bold">Pesan</span>
        </a>

        {{-- Tautan Akun --}}
        <a href="{{ route('account.index') }}" id="akun-link" class="flex flex-col items-center
            {{ request()->routeIs('account.index') ? 'text-blue-600' : 'text-gray-500' }}"
            aria-label="Akun">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
            </svg>
            <span class="text-xs mt-1 font-bold">Akun</span>
        </a>
    </nav>
</footer>
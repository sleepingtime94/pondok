@extends('layouts.app')
@section('content')

<div class="max-w-4xl mx-auto p-4 pb-20">
    
    <div class="swiper mySwiper rounded-lg">
        <div class="swiper-wrapper">
            <div class="swiper-slide flex justify-center">
                <a href="{{ asset('images/1.jpg') }}" data-src="{{ asset('images/1.jpg') }}" class="lightbox-link relative w-[950px] h-[498px] overflow-hidden rounded-2xl">
                    <img src="{{ asset('images/1.jpg') }}" class="w-full h-full object-cover" alt="Maklumat 1">
                </a>
            </div>
            <div class="swiper-slide flex justify-center">
                <a href="{{ asset('images/2.jpg') }}" data-src="{{ asset('images/2.jpg') }}" class="lightbox-link relative w-[950px] h-[498px] overflow-hidden rounded-2xl">
                    <img src="{{ asset('images/2.jpg') }}" class="w-full h-full object-cover" alt="Maklumat 2">
                </a>
            </div>
            <div class="swiper-slide flex justify-center">
                <a href="{{ asset('images/3.jpg') }}" data-src="{{ asset('images/3.jpg') }}" class="lightbox-link relative w-[950px] h-[498px] overflow-hidden rounded-2xl">
                    <img src="{{ asset('images/3.jpg') }}" class="w-full h-full object-cover" alt="Maklumat 3">
                </a>
            </div>
            <div class="swiper-slide flex justify-center">
                <a href="{{ asset('images/4.jpg') }}" data-src="{{ asset('images/4.jpg') }}" class="lightbox-link relative w-[950px] h-[498px] overflow-hidden rounded-2xl">
                    <img src="{{ asset('images/4.jpg') }}" class="w-full h-full object-cover" alt="Maklumat 4">
                </a>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <section class="mt-4 bg-white/70 backdrop-blur-sm rounded-lg shadow-xl p-4">
        <div class="grid grid-cols-4 gap-2">
            @auth
            {{-- Bagian ini ditampilkan jika pengguna sudah login --}}
            <a href="{{ route('logout') }}" class="flex flex-col items-center justify-center space-y-1 transform transition duration-100 hover:scale-105" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <img src="{{ asset('icon/logout1.png') }}" alt="Logout" class="h-8 w-8 object-contain">
                <span class="text-xs text-center font-bold mb-2 text-gray-700">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @else
                {{-- Bagian ini ditampilkan jika pengguna belum login --}}
                <a href="{{ route('login') }}" class="flex flex-col items-center justify-center space-y-1 transform transition duration-100 hover:scale-105">
                    <img src="{{ asset('icon/login.png') }}" alt="Login" class="h-8 w-8 object-contain">
                    <span class="text-xs text-center font-bold mb-2 text-gray-700">Login</span>
                </a>
            @endauth
            <a href="/formulir" class="flex flex-col items-center justify-center space-y-1 transform transition duration-100 hover:scale-105">
                <img src="{{ asset('icon/formulir.png') }}" alt="Formulir" class="h-8 w-8 object-contain">
                <span class="text-xs text-center font-bold mb-2 text-gray-700">Formulir</span>
            </a>
            <a href="/persyaratan" class="flex flex-col items-center justify-center space-y-1 transform transition duration-100 hover:scale-105">
                <img src="{{ asset('icon/syarat1.png') }}" alt="Persyaratan" class="h-8 w-8 object-contain">
                <span class="text-xs text-center font-bold mb-2 text-gray-700">Syarat</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center space-y-1 transform transition duration-100 hover:scale-105">
                <img src="{{ asset('icon/Tutorial1.png') }}" alt="Tutorial" class="h-8 w-8 object-contain">
                <span class="text-xs text-center font-bold mb-2 text-gray-700">Tutorial</span>
            </a>
        </div>
    </section>

<style>
    .material-symbols-outlined {
        font-size: 72px;
        color: blue;
        font-variation-settings:
        'FILL' 1,
        'wght' 400,
        'GRAD' 0,
        'opsz' 48;
    }

    /* Kode CSS untuk animasi bounce yang lebih baik */
    @keyframes bounce-up {
        0% {
            opacity: 0;
            /* Dimulai dari bawah dengan jarak yang lebih jauh */
            transform: translateY(200px);
        }
        60% {
            /* Memantul ke atas dan sedikit overshoot */
            transform: translateY(-10px);
        }
        80% {
            /* Memantul ke bawah sedikit sebelum berhenti */
            transform: translateY(7px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-bounce-up {
        animation: bounce-up 0.7s ease-out;
        animation-fill-mode: backwards;
    }
    .animate-bounce-up-delay {
        animation: bounce-up 0.7s ease-out 0.7s;
        animation-fill-mode: backwards;
    }
</style>

    <section class="mt-4">
        {{-- <h2 class="text-lg font-bold mb-2 text-center">Pilih Layanan</h2> --}}
        <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
            {{-- Layanan Online --}}
            <a href="javascript:void(0);" id="adminduk-link" class="animate-bounce-up bg-white/70 rounded-lg shadow-xl overflow-hidden flex flex-col items-center justify-center p-4 transform transition duration-300 hover:scale-105 hover:bg-gray-100">
                <img src="{{ asset('icon/online2.png') }}" alt="Layanan Online" class="w-20 h-20 mb-2">
                <p class="font-bold text-black-500 mt-1 text-center">Layanan Online</p>
            </a>

            {{-- Lapor Kedatangan (Tambahkan ID: kedatangan-link) --}}
            <a href="/form_pengajuan?keterangan=DTG&judul=Kedatangan%20Luar Daerah&icon=kedatangan.png" id="kedatangan-link" class="animate-bounce-up bg-white/70 rounded-lg shadow-xl overflow-hidden flex flex-col items-center justify-center p-4 transform transition duration-300 hover:scale-105 hover:bg-gray-100">
                <img src="{{ asset('icon/kedatangan.png') }}" alt="Lapor Kedatangan" class="w-20 h-20 mb-2">
                <p class="font-bold text-black-500 mt-1 text-center">Kedatangan Luar Daerah</p>
            </a>
        </div>
    </section>
    <br>
    <section class="text-center py-10 relative z-10 animate-bounce-up-delay">
        <style>
            .merah {
                color: blue;
                font-weight: bold;
            }
            .biru {
                color: green;
                font-weight: bold;
            }
            .hijau {
                color: orange;
                font-weight: bold;
            }
            .kuning {
                color: red;
                font-weight: bold;
            }
        </style>
        <p class="mt-2 text-black/70">
            <span class="merah">P</span>elayanan <span class="biru">On</span>line
            <span class="hijau">Do</span>kumen <span class="kuning">K</span>ependudukan
        </p>
        <h2 style="font-size: 2.25rem; font-weight: bold;">
            <span class="merah">DIS</span><span class="biru">DUK</span><span class="hijau">CA</span><span class="kuning">PIL</span>
        </h2>
        <img src="{{ asset('icon/jargon2.png') }}" alt="Jargon Tapin" class="mt-4 mx-auto w-45 h-20">
    </section>
</div>

{{-- HTML MODAL LOGIN - ID: login-modal --}}
<div id="login-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    
    {{-- Container untuk pemusatan penuh --}}
    {{-- Menggunakan min-h-full dan menghapus kelas responsif yang berpotensi memecahkan pemusatan Flexbox --}}
    <div class="flex items-center justify-center min-h-full px-4 py-6 text-center"> 
        
        {{-- BackDrop (Lapisan Abu-abu Transparan) --}}
        {{-- Z-index disetel ke 40 (lebih rendah dari konten modal) --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-40" aria-hidden="true"></div> 
        
        {{-- Kotak Konten Modal (Kotak Putih) --}}
        {{-- Z-index disetel ke 50 (paling atas) --}}
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl 
                    transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6 
                    relative z-50"> 
            
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.017 3.377 1.517 3.377h13.064c1.5 0 2.383-1.877 1.517-3.377L12.99 3.375c-.865-1.5-2.29-1-3.155 0L2.696 16.501z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Akses Ditolak
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Anda belum login. Silahkan login atau daftar terlebih dahulu untuk mengakses layanan ini.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-4 flex flex-col sm:flex-row-reverse gap-y-2 sm:gap-x-3">
                <a href="{{ route('register') }}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto sm:text-sm">
                    Daftar
                </a>
                <a href="{{ route('login') }}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm">
                    Login
                </a>
                <button type="button" id="close-modal-btn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Deklarasi variabel
        const admindukLink = document.getElementById('adminduk-link');
        const loginModal = document.getElementById('login-modal');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const pengajuanLink = document.getElementById('pengajuan-link');
        const riwayatLink = document.getElementById('riwayat-link');
        const akunLink = document.getElementById('akun-link');
        // const konsultasiLink = document.getElementById('konsultasi-link'); // Dihapus karena ID tidak ada di HTML
        const kedatanganLink = document.getElementById('kedatangan-link'); // Sudah ditambahkan ID di HTML

        // Pastikan elemen penting (Modal dan Tombol Tutup) ditemukan
        if (loginModal && closeModalBtn) {
            function showModal() {
                loginModal.classList.remove('hidden');
            }

            function hideModal() {
                loginModal.classList.add('hidden');
            }

            // Memasang listener pada tombol tutup
            closeModalBtn.addEventListener('click', hideModal);

            @guest
            // Logika ketika user BELUM login: Tampilkan Modal

            // 1. Link Layanan Online (adminduk-link)
            if (admindukLink) { 
                admindukLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    showModal();
                });
            }

            // 2. Link Lacak (pengajuan-link) - dari footer
            if (pengajuanLink) {
                pengajuanLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    showModal();
                });
            }
            
            // 3. Link Riwayat (riwayatLink) - dari footer
            if (riwayatLink) {
                riwayatLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    showModal();
                });
            }
            
            // 4. Link Akun (akunLink) - dari footer
            if (akunLink) {
                akunLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    showModal();
                });
            }
            
            // 5. Link Kedatangan
            if (kedatanganLink) {
                kedatanganLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    showModal();
                });
            }

            @else
            // Logika ketika user SUDAH login: Redirect

            if (admindukLink) {
                admindukLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.location.href = '/layanan';
                });
            }

            if (pengajuanLink) {
                pengajuanLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.location.href = '/tracking';
                });
            }

            if (riwayatLink) {
                riwayatLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.location.href = '/transaksi';
                });
            }

            if (akunLink) {
                akunLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.location.href = '/account';
                });
            }

            if (kedatanganLink) {
                kedatanganLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.location.href = '/form_pengajuan?keterangan=datang&judul=Kedatangan%20Luar%20Daerah&icon=kedatangan.png';
                });
            }
            @endguest
        }
    });
</script>

{{-- SCRIPT LIGHTBOX UNTUK GAMBAR SLIDER --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mendapatkan semua link yang memiliki kelas lightbox-link
        const lightboxLinks = document.querySelectorAll('.lightbox-link');
        
        lightboxLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah browser membuka link
                
                // Mendapatkan URL gambar dari atribut href
                const imageUrl = this.getAttribute('href');
                
                // Membuat overlay untuk lightbox
                const overlay = document.createElement('div');
                overlay.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
                
                // Membuat elemen gambar untuk ditampilkan di dalam overlay
                const imgElement = document.createElement('img');
                imgElement.src = imageUrl;
                imgElement.className = 'max-w-full max-h-full';
                
                overlay.appendChild(imgElement);
                document.body.appendChild(overlay);
                
                // Menutup lightbox saat overlay diklik
                overlay.addEventListener('click', function() {
                    document.body.removeChild(overlay);
                });
            });
        });
    });
</script>
@endsection

@push('scripts')
{{-- SweetAlert2 already loaded in app.blade.php --}}
    

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif
@endpush
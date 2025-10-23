@extends('layouts.app')
@section('content')

{{-- <div class="p-4"> --}}
    <div class="max-w-4xl mx-auto p-4 pb-20">  
        <div class="text-center mb-6">
            <div class="w-24 h-24 mx-auto mb-4">
                <img src="{{ asset('icon/online2.png') }}" alt="Ikon Layanan Online" class="w-full h-full object-contain">
            </div>
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-2">Layanan Online</h2>
            <p class="text-center font-bold text-gray-600 mb-6" id="form-subtitle">Silahkan Pilih Layanan</p>
        </div>
        
        <div>
            <h2 class="text-lg font-bold text-gray-700 mt-4 mb-2">Pencatatan Sipil</h2>
            <div class="space-y-4">
                <a href="/form_pengajuan?keterangan=ALH&judul=Akta%20Kelahiran&icon=akta-kelahiran.png" class="block transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center p-4 bg-white rounded-xl shadow-md">
                        <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg mr-4">
                            <img src="{{ asset('icon/akta-kelahiran.png') }}" alt="Akta Kelahiran" class="h-8 w-8 object-contain">
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 font-semibold text-base">Akta Kelahiran</p>
                            <p class="text-gray-500 text-sm">Layanan Permohonan Penerbitan Akta Kelahiran</p>
                        </div>
                        <div class="ml-4 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="/form_pengajuan?keterangan=AMT&judul=Akta%20Kematian&icon=kematian.png" class="block transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center p-4 bg-white rounded-xl shadow-md">
                        <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg mr-4">
                            <img src="{{ asset('icon/kematian.png') }}" alt="Akta Kematian" class="h-8 w-8 object-contain">
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 font-semibold text-base">Akta Kematian</p>
                            <p class="text-gray-500 text-sm">Layanan Permohonan Penerbitan Akta Kematian</p>
                        </div>
                        <div class="ml-4 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="/form_pengajuan?keterangan=AKW&judul=Akta%20Perkawinan&icon=perkawinan.png" class="block transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center p-4 bg-white rounded-xl shadow-md">
                        <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg mr-4">
                            <img src="{{ asset('icon/perkawinan.png') }}" alt="Akta Kematian" class="h-8 w-8 object-contain">
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 font-semibold text-base">Akta Perkawinan</p>
                            <p class="text-gray-500 text-sm">Layanan Permohonan Penerbitan Akta Perkawinan Non Muslim</p>
                        </div>
                        <div class="ml-4 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </a>
                <a href="/form_pengajuan?keterangan=ACR&judul=Akta%20Perceraian&icon=perceraian.png" class="block transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center p-4 bg-white rounded-xl shadow-md">
                        <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg mr-4">
                            <img src="{{ asset('icon/perceraian.png') }}" alt="Akta Kematian" class="h-8 w-8 object-contain">
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 font-semibold text-base">Akta Perceraian</p>
                            <p class="text-gray-500 text-sm">Layanan Permohonan Penerbitan Akta Perceraian Non Muslim</p>
                        </div>
                        <div class="ml-4 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <h2 class="text-lg font-bold text-gray-700 mt-6 mb-2">Pendaftaran Penduduk</h2>
            <div class="space-y-4">
                <a href="/form_pengajuan?keterangan=KK&judul=Kartu%20Keluarga&icon=kk.png" class="block transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center p-4 bg-white rounded-xl shadow-md">
                        <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg mr-4">
                            <img src="{{ asset('icon/kk.png') }}" alt="Kartu Keluarga" class="h-8 w-8 object-contain">
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 font-semibold text-base">Perbaikan Data (Kartu Keluarga)</p>
                            <p class="text-gray-500 text-sm">Layanan Perbaikan Elemen Data Kependudukan / Pisah KK</p>
                        </div>
                        <div class="ml-4 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="/form_pengajuan?keterangan=KTP&judul=Kartu%20Tanda%20Penduduk&icon=ktp.png" class="block transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center p-4 bg-white rounded-xl shadow-md">
                        <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg mr-4">
                            <img src="{{ asset('icon/ktp.png') }}" alt="KTP" class="h-8 w-8 object-contain">
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 font-semibold text-base">Kartu Tanda Penduduk</p>
                            <p class="text-gray-500 text-sm">Layanan Permohonan Penerbitan KTP-el</p>
                        </div>
                        <div class="ml-4 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="/form_pengajuan?keterangan=KIA&judul=Kartu%20Identitas%20Anak&icon=kia.png" class="block transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center p-4 bg-white rounded-xl shadow-md">
                        <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg mr-4">
                            <img src="{{ asset('icon/kia.png') }}" alt="Kartu Identitas Anak" class="h-8 w-8 object-contain">
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 font-semibold text-base">Kartu Identitas Anak</p>
                            <p class="text-gray-500 text-sm">Layanan Permohonan Penerbitan Kartu Identitas Anak</p>
                        </div>
                        <div class="ml-4 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="/form_pengajuan?keterangan=PDH&judul=Lapor%20Perpindahan&icon=pindah.png" class="block transform transition duration-300 hover:scale-105 hover:shadow-lg" class="block transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center p-4 bg-white rounded-xl shadow-md">
                        <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg mr-4">
                            <img src="{{ asset('icon/pindah.png') }}" alt="Perpindahan" class="h-8 w-8 object-contain">
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 font-semibold text-base">Perpindahan Penduduk</p>
                            <p class="text-gray-500 text-sm">Layanan Permohonan Pindah Dalam/Luar Kabupaten Tapin</p>
                        </div>
                        <div class="ml-4 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="/form_pengajuan?keterangan=DTG&judul=Lapor%20Kedatangan&icon=kedatangan.png" class="block transform transition duration-300 hover:scale-105 hover:shadow-lg" class="block transform transition duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center p-4 bg-white rounded-xl shadow-md">
                        <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg mr-4">
                            <img src="{{ asset('icon/kedatangan.png') }}" alt="Kedatangan" class="h-8 w-8 object-contain">
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 font-semibold text-base">Kedatangan Penduduk</p>
                            <p class="text-gray-500 text-sm">Layanan Permohonan Kedatangan Dalam/Luar Kabupaten Tapin</p>
                        </div>
                        <div class="ml-4 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
{{-- </div> --}}
@endsection
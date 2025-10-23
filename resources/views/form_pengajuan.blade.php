@extends('layouts.app')
@section('content')

<script>
    window.assetPath = "{{ asset('icon') }}";
</script>

<div class="min-h-screen pt-0 flex items-start justify-center"> 
    <div class="w-full max-w-xl bg-white/50 backdrop-blur-sm rounded-lg shadow-xl p-8 transform transition-transform duration-500 ease-in-out relative">
        <a href="{{ url('/layanan') }}" class="absolute top-4 left-4 text-gray-600 hover:text-blue-600 !important transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
            </svg>
        </a>

        <div class="text-center mb-6">
            <div class="w-24 h-24 mx-auto mb-4">
                <img src="{{ asset('icon/ulang1.png') }}" alt="Ikon Layanan Online" class="w-full h-full object-contain" id="service-icon">
            </div>
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-2" id="service-title">Form Pengajuan</h2>
            <p class="text-center text-gray-600 mb-6" id="form-subtitle">Silakan isi data dengan lengkap, dan klik simpan</p>
        </div>

        <div class="flex justify-center items-center mb-6">
            <div class="flex items-center">
                <div class="rounded-full h-8 w-8 flex items-center justify-center text-white font-bold transition-all duration-300" id="step1-indicator">
                    <span class="material-symbols-outlined text-2xl">looks_one</span>
                </div>
                <div class="w-16 h-1 bg-gray-300 mx-2 rounded-full transition-all duration-300" id="step-line"></div>
                <div class="rounded-full h-8 w-8 flex items-center justify-center text-gray-400 font-bold border-2 border-gray-400 transition-all duration-300" id="step2-indicator">
                    <span class="material-symbols-outlined text-2xl">looks_two</span>
                </div>
            </div>
        </div>

        <form method="POST" action="/submit-pengajuan" id="pengajuan-form" enctype="multipart/form-data">
            @csrf

            <div id="form-inputs">
                <div class="mb-4">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <label for="nik" class="block text-gray-700 text-sm font-bold mb-2">Masukkan NIK</label>
                            <div class="relative flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 text-gray-400 z-10" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                <input id="nik" type="text" name="nik" placeholder="Nomor NIK" class="w-full bg-white border-none shadow-md appearance-none rounded py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-lg"
                                required oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="16" minlength="16"/>
                            </div>
                        </div>

                        <div class="flex-1">
                            <label for="kk" class="block text-gray-700 text-sm font-bold mb-2">Masukkan KK</label>
                            <div class="relative flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 text-gray-400 z-10" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                <input id="kk" type="text" name="kk" placeholder="Nomor KK" class="w-full bg-white border-none shadow-md appearance-none rounded py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-lg"
                                required oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="16" minlength="16"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Masukkan Nama</label>
                    <div class="relative flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 text-gray-400 z-10" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <input id="nama" type="text" name="nama" placeholder="Nama Lengkap"
                                 class="bg-white border-none shadow-md appearance-none rounded w-full py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-lg"
                                 required oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="jenis_layanan" class="block text-gray-700 text-sm font-bold mb-2">Jenis Layanan + Syarat</label>
                    <div class="relative flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 text-gray-400 z-10" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                        </svg>
                        <select id="jenis_layanan" name="jenis_layanan"
                                class="bg-white border-none shadow-md appearance-none rounded w-full py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-lg"
                                required>
                            <option value="">Pilih Layanan</option>
                        </select>
                    </div>
                    <input type="hidden" name="keterangan" id="keterangan" value="KK">
                    {{-- Kotak persyaratan dipindahkan ke sini, di luar div "relative" --}}
                    <div id="persyaratan-box" class="mt-4 p-4 bg-green-100 border border-gray-300 text-gray-800 rounded-lg shadow-sm hidden">
                        <p class="font-bold">Persyaratan :</p>
                        <ul id="persyaratan-list" class="list-decimal ml-5 mt-2 text-sm"></ul>
                    </div>
                </div>

                <!-- Dropdown Pengambilan Dokumen -->
                <div class="mb-4">
                    <label for="pengambilan_dokumen" class="block text-gray-700 text-sm font-bold mb-2">Pengambilan Dokumen</label>
                    <div class="relative flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 text-gray-400 z-10" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                        </svg>
                        <select id="pengambilan_dokumen" name="pengambilan_id"
                                class="bg-white border-none shadow-md appearance-none rounded w-full py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-lg"
                                required>
                            <option value="">Pilih Pengambilan</option>
                            <!-- Opsi akan diisi oleh JavaScript -->
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="isi_informasi" class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
                    <div class="relative flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-3 text-gray-400 z-10" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.373 12.14 2 10.512 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7.5 7a.5.5 0 000 1h5a.5.5 0 000-1h-5zM7.5 9a.5.5 0 000 1h5a.5.5 0 000-1h-5z" clip-rule="evenodd" />
                        </svg>
                        <textarea id="isi_informasi" name="isi_informasi" style="height: 80px;" placeholder="Sampaikan Informasi Anda disini" rows="6"
                                 class="bg-white border-none shadow-md appearance-none rounded w-full py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-lg"
                                 required oninput="this.value = this.value.toUpperCase()"></textarea>
                    </div>
                </div>
            </div>

            <div id="button-group" class="flex items-center justify-between mt-6">
                <button type="button" id="main-button"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-lg focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 flex items-center mr-4">
                    <svg id="main-button-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                    </svg>
                    Simpan
                </button>
                <button type="reset" id="secondary-button"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-lg focus:ring-2 focus:ring-yellow-500 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 flex items-center">
                    <svg id="secondary-button-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Reset
                </button>
            </div>

            {{-- Konfirmasi Langkah 2 --}}
            <div id="confirmation-step" class="hidden">
                <div class="mt-6">
                    {{-- Kontainer untuk input dan pratinjau file --}}
                    <div class="mb-6">
                        <label for="upload-file" class="block text-gray-700 text-sm font-bold mb-2">Unggah File Pendukung</label>
                        <div class="flex items-center space-x-2">
                            <input type="file" id="upload-file" accept="image/jpeg,image/png,image/jpg"
                                class="bg-white border-none shadow-md appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-lg">
                            <button type="button" id="add-file-button" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <span class="material-symbols-outlined text-base">upload</span> Upload
                            </button>
                        </div>
                        <div id="file-preview-container" class="mt-4 space-y-2">
                            {{-- Pratinjau file yang diunggah akan muncul di sini --}}
                        </div>
                    </div>

                    <div class="flex items-center mb-4">
                        <input id="confirmation-checkbox" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="confirmation-checkbox" class="ml-2 block text-sm italic font-bold text-red-600">
                            Saya menyetujui data yang dikirimkan adalah benar.
                        </label>
                    </div>
                </div>
    
                <button type="button" id="final-submit-button" disabled
                    class="w-full bg-blue-400 text-white font-bold py-2 px-6 rounded-lg cursor-not-allowed transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                    Kirim Permohonan
                </button>
            </div>
            <!-- Hidden input untuk trx_id (jika ada) -->
                @if(request('trx_id'))
                    <input type="hidden" name="trx_id" value="{{ request('trx_id') }}">
                @endif
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pengajuan-form');
    const formInputs = document.getElementById('form-inputs');
    const mainButton = document.getElementById('main-button');
    const secondaryButton = document.getElementById('secondary-button');
    const buttonGroup = document.getElementById('button-group');
    const confirmationStep = document.getElementById('confirmation-step');
    const confirmationCheckbox = document.getElementById('confirmation-checkbox');
    const finalSubmitButton = document.getElementById('final-submit-button');
    const uploadFileInput = document.getElementById('upload-file');
    const addFileButton = document.getElementById('add-file-button');
    const filePreviewContainer = document.getElementById('file-preview-container');

    const step1Indicator = document.getElementById('step1-indicator');
    const step2Indicator = document.getElementById('step2-indicator');
    const stepLine = document.getElementById('step-line');
    const formSubtitle = document.getElementById('form-subtitle');

    const jenisLayananSelect = document.getElementById('jenis_layanan');
    const persyaratanBox = document.getElementById('persyaratan-box');
    const persyaratanList = document.getElementById('persyaratan-list');

    let currentStep = 1;
    let uploadedFiles = [];

    // Simpan nilai awal 'keterangan' dari URL agar tidak hilang saat reset
    const urlParams = new URLSearchParams(window.location.search);
    const initialKeterangan = urlParams.get('keterangan') || '';

    function updateUIState() {
        const disableInputs = (currentStep === 2);
        formInputs.querySelectorAll('input, select, textarea').forEach(input => {
            // Jangan disable hidden input (misal: keterangan)
            if (input.type !== 'hidden') {
                input.disabled = disableInputs;
            }
        });

        confirmationCheckbox.checked = false;
        finalSubmitButton.disabled = true;
        finalSubmitButton.classList.replace('bg-blue-600', 'bg-blue-400');
        finalSubmitButton.classList.replace('cursor-pointer', 'cursor-not-allowed');

        if (currentStep === 1) {
            buttonGroup.classList.remove('hidden');
            confirmationStep.classList.add('hidden');

            mainButton.innerHTML = `<svg id="main-button-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 5.25 6H10" /></svg> Simpan`;
            mainButton.classList.replace('bg-red-600', 'bg-blue-600');
            secondaryButton.innerHTML = `<svg id="secondary-button-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg> Reset`;
            secondaryButton.classList.replace('bg-green-500', 'bg-yellow-500');
            secondaryButton.setAttribute('type', 'button');

            step1Indicator.classList.add('bg-blue-600');
            step1Indicator.classList.remove('bg-green-500', 'text-gray-400', 'border-2', 'border-gray-400');
            step2Indicator.classList.add('text-gray-400', 'border-2', 'border-gray-400');
            step2Indicator.classList.remove('bg-blue-600', 'text-white');
            stepLine.classList.add('bg-gray-300');
            stepLine.classList.remove('bg-green-500');

            formSubtitle.textContent = "Silakan isi data dengan lengkap, dan klik simpan.";
        } else if (currentStep === 2) {
            buttonGroup.classList.remove('hidden');
            confirmationStep.classList.remove('hidden');

            mainButton.innerHTML = `<svg id="main-button-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg> Edit`;
            mainButton.classList.replace('bg-blue-600', 'bg-red-600');
            secondaryButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" /></svg> Batal`;
            secondaryButton.classList.replace('bg-yellow-500', 'bg-green-500');
            secondaryButton.setAttribute('type', 'button');

            step1Indicator.classList.remove('bg-blue-600');
            step1Indicator.classList.add('bg-green-500', 'text-white');
            step2Indicator.classList.remove('text-gray-400', 'border-2', 'border-gray-400');
            step2Indicator.classList.add('bg-blue-600', 'text-white');
            stepLine.classList.remove('bg-gray-300');
            stepLine.classList.add('bg-green-500');

            formSubtitle.textContent = "Data Anda berhasil disimpan sementara. Silakan konfirmasi data Anda.";
        }
    }

    function renderFilePreview() {
        filePreviewContainer.innerHTML = '';
        uploadedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.classList.add('flex', 'items-center', 'justify-between', 'bg-gray-100', 'p-2', 'rounded-lg');

            const fileContent = document.createElement('div');
            fileContent.classList.add('flex', 'items-center', 'space-x-2');

            if (file.type.startsWith('image/')) {
                const imgPreview = document.createElement('img');
                imgPreview.src = URL.createObjectURL(file);
                imgPreview.classList.add('h-8', 'w-8', 'object-cover', 'rounded');
                imgPreview.alt = file.name;
                fileContent.appendChild(imgPreview);
            } else {
                const fileIcon = document.createElement('span');
                fileIcon.classList.add('material-symbols-outlined', 'text-gray-500', 'text-lg');
                if (file.type === 'application/pdf') {
                    fileIcon.textContent = 'picture_as_pdf';
                } else if (file.type.includes('word')) {
                    fileIcon.textContent = 'description';
                } else if (file.type.includes('excel')) {
                    fileIcon.textContent = 'grid_on';
                } else {
                    fileIcon.textContent = 'attachment';
                }
                fileContent.appendChild(fileIcon);
            }

            const fileNameSpan = document.createElement('span');
            fileNameSpan.textContent = file.name;
            fileNameSpan.classList.add('text-sm', 'font-medium', 'text-blue-700', 'cursor-pointer', 'hover:underline');
            fileNameSpan.addEventListener('click', () => {
                const fileURL = URL.createObjectURL(file);
                window.open(fileURL, '_blank');
                URL.revokeObjectURL(fileURL);
            });
            fileContent.appendChild(fileNameSpan);

            const deleteButton = document.createElement('button');
            deleteButton.innerHTML = '<span class="material-symbols-outlined text-base text-red-500">close</span>';
            deleteButton.classList.add('p-1', 'rounded-full', 'hover:bg-gray-200');
            deleteButton.addEventListener('click', () => {
                uploadedFiles.splice(index, 1);
                renderFilePreview();
            });

            fileItem.appendChild(fileContent);
            fileItem.appendChild(deleteButton);
            filePreviewContainer.appendChild(fileItem);
        });
    }

    function populateJenisLayananDropdown(data) {
        jenisLayananSelect.innerHTML = '<option value="">Pilih Layanan</option>';
        data.forEach(layanan => {
            const option = document.createElement('option');
            option.value = layanan.id;
            option.textContent = layanan.nama;
            option.setAttribute('data-persyaratan', layanan.persyaratan);
            jenisLayananSelect.appendChild(option);
        });
    }

    async function fetchFilteredJenisLayanan(keterangan) {
        jenisLayananSelect.innerHTML = '<option value="">Pilih Layanan</option>';
        jenisLayananSelect.disabled = true;
        try {
            const response = await fetch(`/api/jenis-layanan/filter/${keterangan}`);
            const data = await response.json();
            populateJenisLayananDropdown(data);
            jenisLayananSelect.disabled = false;
        } catch (error) {
            console.error('Error fetching jenis layanan:', error);
            jenisLayananSelect.innerHTML = '<option value="">Gagal memuat data</option>';
            jenisLayananSelect.disabled = false;
        }
    }

    async function loadPengambilanDokumen() {
        const select = document.getElementById('pengambilan_dokumen');
        if (!select) {
            console.error('❌ Element #pengambilan_dokumen tidak ditemukan!');
            return;
        }

        try {
            const response = await fetch('/api/pengambilan-dokumen');
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            const data = await response.json();
            select.innerHTML = '<option value="">Pilih Pengambilan</option>';
            if (Array.isArray(data)) {
                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.id;
                    opt.textContent = item.nama;
                    select.appendChild(opt);
                });
            }
        } catch (error) {
            console.error('❌ Gagal load pengambilan dokumen:', error);
            select.innerHTML = '<option value="">Gagal memuat data</option>';
        }
    }

    async function submitFormToBackend() {
        mainButton.textContent = 'Menyimpan...';
        mainButton.disabled = true;
        finalSubmitButton.disabled = true;

        // 🔥 PENTING: Aktifkan SEMUA field sebelum kirim (termasuk yang disabled)
        form.querySelectorAll('input, select, textarea').forEach(el => {
            el.disabled = false;
        });

        const formData = new FormData(form);
        uploadedFiles.forEach((file, index) => {
            formData.append(`file_pendukung[${index}]`, file);
        });

        try {
            const response = await fetch('/submit-pengajuan', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const textResponse = await response.text();
            console.log('Respons Server Mentah:', textResponse);

            if (response.ok) {
                const result = JSON.parse(textResponse);
                if (result.id_trx) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Permohonan berhasil dikirim!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = `/tracking/${result.id_trx}`;
                    });
                } else {
                    Swal.fire('Error', 'ID Transaksi tidak ditemukan', 'error');
                }
            } else {
                const result = JSON.parse(textResponse);
                let errorMessage = 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.';
                if (response.status === 422 && result.errors) {
                    const errorMessages = Object.keys(result.errors).map(field => {
                        if (result.errors[field].includes('validation.required')) {
                            let fieldName = '';
                            switch(field) {
                                case 'nik': fieldName = 'NIK'; break;
                                case 'nama': fieldName = 'Nama'; break;
                                case 'jenis_layanan': fieldName = 'Jenis Layanan'; break;
                                case 'pengambilan_dokumen': fieldName = 'Pengambilan Dokumen'; break;
                                case 'keterangan': fieldName = 'Keterangan'; break;
                                default: fieldName = field;
                            }
                            return `- ${fieldName} wajib diisi.`;
                        }
                        return result.errors[field].flat().join('<br>');
                    }).join('<br>');

                    errorMessage = `<div class="text-left">Harap lengkapi data berikut: <br><br>${errorMessages}</div>`;
                }
                Swal.fire({
                    title: 'Error!',
                    html: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan, silakan coba lagi.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } finally {
            mainButton.textContent = currentStep === 1 ? 'Simpan' : 'Edit';
            mainButton.disabled = false;
            finalSubmitButton.disabled = !confirmationCheckbox.checked;

            // Kembalikan ke kondisi disabled jika masih di step 2
            if (currentStep === 2) {
                formInputs.querySelectorAll('input, select, textarea').forEach(input => {
                    if (input.type !== 'hidden') {
                        input.disabled = true;
                    }
                });
            }
        }
    }

    // --- Event listeners ---
    mainButton.addEventListener('click', function(e) {
        if (mainButton.textContent.trim().toLowerCase().includes('simpan')) {
            e.preventDefault();
            if (form.checkValidity()) {
                currentStep = 2;
                updateUIState();
            } else {
                form.reportValidity();
            }
        } else if (mainButton.textContent.trim().toLowerCase().includes('edit')) {
            e.preventDefault();
            currentStep = 1;
            updateUIState();
        }
    });

    // Fungsi reset form lengkap
    function resetForm() {
        const resettable = form.querySelectorAll('input:not([type="hidden"]), select, textarea');
        resettable.forEach(el => {
            if (el.type === 'checkbox' || el.type === 'radio') {
                el.checked = false;
            } else {
                el.value = '';
            }
        });

        const keteranganInput = document.getElementById('keterangan');
        if (keteranganInput && initialKeterangan) {
            keteranganInput.value = initialKeterangan;
        }

        uploadedFiles = [];
        renderFilePreview();

        jenisLayananSelect.dispatchEvent(new Event('change', { bubbles: true }));
    }

    secondaryButton.addEventListener('click', function(e) {
        e.preventDefault();
        if (currentStep === 1) {
            resetForm();
        } else if (currentStep === 2) {
            currentStep = 1;
            resetForm();
            updateUIState();
        }
    });

    finalSubmitButton.addEventListener('click', function(e) {
        e.preventDefault();
        submitFormToBackend();
    });

    confirmationCheckbox.addEventListener('change', function() {
        finalSubmitButton.disabled = !this.checked;
        if (this.checked) {
            finalSubmitButton.classList.replace('bg-blue-400', 'bg-blue-600');
            finalSubmitButton.classList.replace('cursor-not-allowed', 'cursor-pointer');
        } else {
            finalSubmitButton.classList.replace('bg-blue-600', 'bg-blue-400');
            finalSubmitButton.classList.replace('cursor-pointer', 'cursor-not-allowed');
        }
    });

    addFileButton.addEventListener('click', () => {
        const file = uploadFileInput.files[0];
        if (file) {
            uploadedFiles.push(file);
            renderFilePreview();
            uploadFileInput.value = '';
        }
    });

    jenisLayananSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const persyaratan = selectedOption.getAttribute('data-persyaratan');
        persyaratanList.innerHTML = '';
        if (persyaratan) {
            const items = persyaratan.split(/[\r\n,]+/).map(item => item.trim()).filter(item => item.length > 0);
            if (items.length > 0) {
                items.forEach(item => {
                    const li = document.createElement('li');
                    li.textContent = item;
                    persyaratanList.appendChild(li);
                });
                persyaratanBox.classList.remove('hidden');
            } else {
                persyaratanBox.classList.add('hidden');
            }
        } else {
            persyaratanBox.classList.add('hidden');
        }
    });

    if (initialKeterangan) {
        const keteranganInput = document.getElementById('keterangan');
        if (keteranganInput) {
            keteranganInput.value = initialKeterangan;
        }
        fetchFilteredJenisLayanan(initialKeterangan);
    } else {
        jenisLayananSelect.innerHTML = '<option value="">Silakan pilih layanan dari halaman sebelumnya</option>';
    }

    const serviceTitle = urlParams.get('judul');
    if (serviceTitle) {
        const titleElement = document.getElementById('service-title');
        if (titleElement) {
            titleElement.textContent = decodeURIComponent(serviceTitle);
        }
    }

    const serviceIcon = urlParams.get('icon');
    if (serviceIcon) {
        const iconElement = document.getElementById('service-icon');
        if (iconElement) {
            const iconPath = `${window.assetPath}/${serviceIcon}`;
            const testImg = new Image();
            testImg.onload = () => {
                iconElement.src = iconPath;
            };
            testImg.onerror = () => {
                console.warn(`Ikon ${serviceIcon} tidak ditemukan, gunakan default.`);
                iconElement.src = `${window.assetPath}/konsultasi.png`;
            };
            testImg.src = iconPath;
        }
    }

    loadPengambilanDokumen();
    updateUIState();
});
</script>
@endpush
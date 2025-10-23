@extends('layouts.app')

@section('content')

<div class="min-h-screen pt-0 flex items-start justify-center">
    <div class="w-full max-w-xl bg-white/50 backdrop-blur-sm rounded-lg shadow-xl p-8 transform transition-transform duration-500 ease-in-out">
        <a href="{{ url('/') }}" class="absolute top-4 left-4 text-gray-600 hover:text-blue-600 !important transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
            </svg>
        </a>

        <div class="text-center mb-6">
            <div class="w-24 h-24 mx-auto mb-4">
                <img src="{{ asset('icon/konsultasi.png') }}" alt="Ikon Layanan Online" class="w-full h-full object-contain">
            </div>
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-2">Layanan Konsultasi</h2>
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

        <form method="POST" action="/submit-konsultasi" id="konsultasi-form" enctype="multipart/form-data">
            @csrf

            <div id="form-inputs">
                <div class="mb-4">
                    <label for="nik" class="block text-gray-700 text-sm font-bold mb-2">Masukkan NIK</label>
                    <div class="relative flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 text-gray-400 z-10" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <input id="nik" type="text" name="nik" placeholder="Masukkan NIK"
                            class="bg-white border-none shadow-md appearance-none rounded w-full py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-lg"
                            required oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                            maxlength="16" minlength="16">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Masukkan Nama</label>
                    <div class="relative flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 text-gray-400 z-10" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <input id="nama" type="text" name="nama" placeholder="Masukkan Nama Anda"
                                class="bg-white border-none shadow-md appearance-none rounded w-full py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-lg"
                                required oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="nomor_hp" class="block text-gray-700 text-sm font-bold mb-2">Masukkan No Whatsapp</label>
                    <div class="relative flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 text-gray-400 z-10" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 2.19a1 1 0 01-.186 1.05l-1.545 1.545a9 9 0 004.95 4.95l1.545-1.545a1 1 0 011.05-.186l2.19.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.942 18 2 12.058 2 5V3z" />
                        </svg>
                        <input id="nomor_hp" type="text" name="nomor_hp" placeholder="Masukkan No Whatsapp"
                                class="bg-white border-none shadow-md appearance-none rounded w-full py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-lg"
                                required oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="jenis_konsultasi" class="block text-gray-700 text-sm font-bold mb-2">Pilih Jenis Konsultasi</label>
                    <div class="relative flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 text-gray-400 z-10" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                        </svg>
                        <select id="jenis_konsultasi" name="jenis_konsultasi"
                                 class="bg-white border-none shadow-md appearance-none rounded w-full py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-lg"
                                 required>
                            <option value="">Pilih</option>
                            @foreach($jenisPengaduan as $pengaduan)
                                <option value="{{ $pengaduan->id_jenis }}">
                                    {{ $pengaduan->keterangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="isi_informasi" class="block text-gray-700 text-sm font-bold mb-2">Masukkan Isi Informasi</label>
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
                        <label for="upload-file" class="block text-gray-700 text-sm font-bold mb-2">Unggah File Pendukung (Opsional)</label>
                        <div class="flex items-center space-x-2">
                            <input type="file" id="upload-file" accept="image/jpeg,image/png,image/jpg"
                                class="bg-white border-none shadow-md appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-lg">
                            <button type="button" id="add-file-button" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <span class="material-symbols-outlined text-base">upload</span> Unggah
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
        </form>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('konsultasi-form');
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

        let currentStep = 1;
        let uploadedFiles = [];

        function updateUIState() {
            const disableInputs = (currentStep === 2);
            formInputs.querySelectorAll('input, select, textarea').forEach(input => {
                input.disabled = disableInputs;
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
                secondaryButton.setAttribute('type', 'reset');
                
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
                
                // --- Bagian yang akan diubah ---
                const fileContent = document.createElement('div');
                fileContent.classList.add('flex', 'items-center', 'space-x-2'); // Agar ikon/gambar dan nama file sejajar

                if (file.type.startsWith('image/')) {
                    // Jika file adalah gambar, buat elemen img sebagai pratinjau
                    const imgPreview = document.createElement('img');
                    imgPreview.src = URL.createObjectURL(file); // Membuat URL lokal untuk pratinjau
                    imgPreview.classList.add('h-8', 'w-8', 'object-cover', 'rounded'); // Styling untuk gambar kecil
                    imgPreview.alt = file.name;
                    fileContent.appendChild(imgPreview);
                } else {
                    // Jika bukan gambar, tambahkan ikon placeholder
                    const fileIcon = document.createElement('span');
                    fileIcon.classList.add('material-symbols-outlined', 'text-gray-500', 'text-lg');
                    // Anda bisa menyesuaikan ikon berdasarkan tipe file jika mau
                    if (file.type === 'application/pdf') {
                        fileIcon.textContent = 'picture_as_pdf';
                    } else if (file.type.includes('word')) { // Contoh untuk Word
                        fileIcon.textContent = 'description';
                    } else if (file.type.includes('excel')) { // Contoh untuk Excel
                        fileIcon.textContent = 'grid_on';
                    } else {
                        fileIcon.textContent = 'attachment';
                    }
                    fileContent.appendChild(fileIcon);
                }

                const fileNameSpan = document.createElement('span');
                fileNameSpan.textContent = file.name;
                fileNameSpan.classList.add('text-sm', 'font-medium', 'text-blue-700', 'cursor-pointer', 'hover:underline');
                // Tambahkan event listener untuk membuka file saat diklik
                fileNameSpan.addEventListener('click', () => {
                    const fileURL = URL.createObjectURL(file);
                    window.open(fileURL, '_blank'); // Buka di tab baru
                    URL.revokeObjectURL(fileURL); // Penting: membebaskan memori setelah dibuka
                });
                fileContent.appendChild(fileNameSpan);
                // --- Akhir bagian yang diubah ---
                
                const deleteButton = document.createElement('button');
                deleteButton.innerHTML = '<span class="material-symbols-outlined text-base text-red-500">close</span>';
                deleteButton.classList.add('p-1', 'rounded-full', 'hover:bg-gray-200');
                deleteButton.addEventListener('click', () => {
                    uploadedFiles.splice(index, 1);
                    renderFilePreview();
                });

                fileItem.appendChild(fileContent); // Masukkan fileContent ke fileItem
                fileItem.appendChild(deleteButton);
                filePreviewContainer.appendChild(fileItem);
            });
        }

        mainButton.addEventListener('click', function(e) {
            if (mainButton.textContent.trim().toLowerCase().includes('simpan')) {
                e.preventDefault();
                
                if (form.checkValidity()) {
                    mainButton.textContent = 'Menyimpan...';
                    mainButton.disabled = true;

                    setTimeout(() => {
                        const formData = new FormData(form);
                        const data = Object.fromEntries(formData.entries());
                        localStorage.setItem('konsultasiData', JSON.stringify(data));
                        
                        currentStep = 2;
                        updateUIState();
                        mainButton.disabled = false;
                    }, 500);
                } else {
                    form.reportValidity();
                }
            } else if (mainButton.textContent.trim().toLowerCase().includes('edit')) {
                e.preventDefault();
                currentStep = 1;
                updateUIState();
            }
        });

        secondaryButton.addEventListener('click', function(e) {
            if (currentStep === 2) {
                e.preventDefault();
                localStorage.removeItem('konsultasiData');
                form.reset();
                currentStep = 1;
                updateUIState();
            }
        });
        
        confirmationCheckbox.addEventListener('change', function() {
            if (this.checked) {
                finalSubmitButton.disabled = false;
                finalSubmitButton.classList.replace('bg-blue-400', 'bg-blue-600');
                finalSubmitButton.classList.replace('cursor-not-allowed', 'cursor-pointer');
            } else {
                finalSubmitButton.disabled = true;
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

        finalSubmitButton.addEventListener('click', function() {
            const savedData = JSON.parse(localStorage.getItem('konsultasiData'));
            const formData = new FormData();
            
            for (const key in savedData) {
                formData.append(key, savedData[key]);
            }
            
            uploadedFiles.forEach((file, index) => {
                formData.append(`file_pendukung[${index}]`, file);
            });

            fetch('/submit-konsultasi', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Ganti alert() sukses dengan SweetAlert
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Konsultasi berhasil dikirim!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        localStorage.removeItem('konsultasiData');
                        // Alihkan ke halaman tracking dengan ID konsul
                        // Pastikan respons dari server Anda mengembalikan `data.id_konsul`
                        window.location.href = '/tracking?id=' + data.id_konsul;
                    });
                } else {
                    // Ganti alert() error dengan SweetAlert
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Ganti alert() error dengan SweetAlert
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan jaringan atau server, silakan coba lagi.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });

        updateUIState();
    });
</script>
@endsection
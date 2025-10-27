@extends('layouts.app')

@section('content')

<script>
    window.assetPath = "{{ asset('icon') }}";
</script>

<div class="min-h-screen pt-0 flex items-start justify-center">
    <div class="w-full max-w-xl bg-white/50 backdrop-blur-sm rounded-lg shadow-xl p-8 transform transition-transform duration-500 ease-in-out relative">
        <a href="{{ route('tracking.show', $transaksi->id_trx) }}" class="absolute top-4 left-4 text-gray-600 hover:text-blue-600 transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
            </svg>
        </a>

        <div class="text-center mb-6">
            <div class="w-24 h-24 mx-auto mb-4">
                <img src="{{ asset('icon/ulang1.png') }}" alt="Ikon Pengajuan Ulang" class="w-full h-full object-contain">
            </div>
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-2">Pengajuan Ulang</h2>
            <p class="text-center text-gray-600 mb-6">
                ID Permohonan : <span class="font-bold text-blue-800">{{ $transaksi->id_trx }}</span>
            </p>
        </div>

        {{-- <form method="POST" action="{{ route('pengajuan.ulang.submit', $transaksi->id_trx) }}" enctype="multipart/form-data"> --}}
        <form id="ulang-form" enctype="multipart/form-data">    
            @csrf

            <div class="mb-4">
                <div class="flex flex-col sm:flex-row gap-4">    
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nomor NIK</label>
                        <input type="text" name="nik" value="{{ old('nik', $transaksi->nik) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="16" minlength="16">
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nomor KK</label>
                        <input type="text" name="kk" value="{{ old('kk', $transaksi->kk ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="16" minlength="16">
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $transaksi->nama) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Layanan</label>
                        <select name="jenis_layanan" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Pilih Jenis Layanan</option>
                            @foreach($jenisPelayanans as $jenis)
                                <option value="{{ $jenis->id }}" 
                                    {{ (old('jenis_layanan') == $jenis->id) || ($transaksi->id_dokumen == $jenis->id) ? 'selected' : '' }}>
                                    {{ $jenis->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pengambilan Dokumen</label>
                        <select name="pengambilan_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Pilih Pengambilan</option>
                            @foreach($pengambilanDokumens as $pengambilan)
                                <option value="{{ $pengambilan->id }}" 
                                    {{ (old('pengambilan_id') == $pengambilan->id) || ($transaksi->pengambilan_id == $pengambilan->id) ? 'selected' : '' }}>
                                    {{ $pengambilan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Keterangan -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="3" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>{{ old('keterangan', $transaksi->keterangan) }}</textarea>
            </div>

            <!-- Upload File dengan Tombol Kustom -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Unggah File Pendukung</label>
                <!-- Input file disembunyikan, tapi tetap punya name dan multiple -->
                <input type="file" id="upload-file" multiple accept="image/jpeg,image/png,image/jpg" class="hidden">

                <div class="flex items-center space-x-2">
                    <button type="button" id="add-file-button"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                        <span class="material-symbols-outlined text-base">upload</span> Upload
                    </button>
                    <span class="text-sm text-gray-500">Format: JPG, PNG (maks. 2MB per file)</span>
                </div>

                <!-- Preview file -->
                <div id="file-preview-container" class="mt-4 space-y-2">
                    {{-- Preview akan diisi oleh JavaScript --}}
                </div>
            </div>

            <!-- File Lama -->
            @if($fileLama->count() > 0)
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 mb-2">File Pendukung Sebelumnya</h4>
                    <div id="file-lama-container" class="space-y-2">
                        @foreach($fileLama as $file)
                            <div class="flex items-center justify-between bg-blue-50 p-2 rounded">
                                <span class="text-sm text-blue-700">{{ basename($file->file) }}</span>
                                <div class="flex space-x-2">
                                    <a href="{{ asset($file->file) }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                        Lihat File
                                    </a>
                                    <button type="button" class="text-red-500 hover:text-red-700 text-sm"
                                            onclick="hapusFileLama('{{ $file->id }}', this)">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Tombol Submit -->
            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('tracking.show', $transaksi->id_trx) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-lg focus:ring-2 focus:ring-yellow-500 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 flex items-center">
                    Kembali
                </a>
                <button type="button" id="submit-btn"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-lg focus:ring-2 focus:ring-yellow-500 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 flex items-center">
                    Kirim Ulang
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('upload-file');
    const addButton = document.getElementById('add-file-button');
    const submitBtn = document.getElementById('submit-btn');
    const previewContainer = document.getElementById('file-preview-container');
    const form = document.getElementById('ulang-form');

    let uploadedFiles = []; // simpan semua file yang dipilih

    addButton.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', () => {
        const files = Array.from(fileInput.files);
        if (files.length === 0) return;

        // Tambahkan ke daftar (hindari duplikat jika perlu)
        uploadedFiles.push(...files);

        // Render semua file (termasuk yang lama)
        renderPreview();

        // Reset input agar event change bisa dipicu ulang untuk file yang sama
        fileInput.value = '';
    });

    function renderPreview() {
        previewContainer.innerHTML = '';
        uploadedFiles.forEach((file, index) => {
            const div = document.createElement('div');
            div.className = 'flex items-center justify-between bg-gray-100 p-2 rounded-lg';
            div.innerHTML = `
                <div class="flex items-center space-x-2">
                    <span class="material-symbols-outlined text-gray-500 text-lg">
                        ${file.type.startsWith('image/') ? 'image' : 'description'}
                    </span>
                    <span class="text-sm font-medium text-blue-700">${file.name}</span>
                </div>
                <button type="button" class="text-red-500 hover:text-red-700" onclick="removeFile(${index})">
                    <span class="material-symbols-outlined text-base">close</span>
                </button>
            `;
            previewContainer.appendChild(div);
        });
    }

    window.removeFile = function(index) {
        uploadedFiles.splice(index, 1);
        renderPreview();
    };

    // Submit form via JavaScript
    submitBtn.addEventListener('click', function () {
        const formData = new FormData();

        // Tambahkan CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        formData.append('_token', csrfToken);

        // Tambahkan field lain
        formData.append('keterangan', document.querySelector('textarea[name="keterangan"]').value);
        formData.append('nik', document.querySelector('input[name="nik"]').value);
        formData.append('kk', document.querySelector('input[name="kk"]').value);
        formData.append('nama', document.querySelector('input[name="nama"]').value);
        formData.append('jenis_layanan', document.querySelector('select[name="jenis_layanan"]').value);
        formData.append('pengambilan_id', document.querySelector('select[name="pengambilan_id"]').value);

        // Tambahkan semua file
        uploadedFiles.forEach(file => {
            formData.append('file_pendukung[]', file);
        });

        // Ambil ID dari URL atau hidden input (opsional)
        const idTrx = "{{ $transaksi->id_trx }}";

        // Kirim
        fetch(`{{ route('pengajuan.ulang.submit', $transaksi->id_trx) }}`, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert('Error: ' + (data.message || 'Gagal mengirim.'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim data.');
        });
    });

    // Fungsi hapus file lama tetap sama
    window.hapusFileLama = function(fileId, button) {
        if (confirm('Hapus file ini?')) {
            fetch(`/api/hapus-file/${fileId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            }).then(r => r.json()).then(data => {
                if (data.success) button.closest('div').remove();
                else alert('Gagal hapus.');
            });
        }
    };
});
</script>
@endpush

@endsection
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

        <form method="POST" action="{{ route('pengajuan.ulang.submit', $transaksi->id_trx) }}" enctype="multipart/form-data">
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
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $transaksi->nama) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
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

            <!-- Upload File Baru -->
            {{-- <div class="mb-4">
                <label for="file_pendukung" class="block text-gray-700 text-sm font-bold mb-2">Upload File Pendukung Baru (Opsional)</label>
                <div class="flex items-center space-x-2">
                    <input type="file" name="file_pendukung[]" id="file_pendukung" multiple
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" id="upload-button" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                        <span class="material-symbols-outlined text-base">upload</span> Upload
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG, PDF (Max: 2MB per file)</p> --}}

                <!-- Preview File yang Diupload -->
                {{-- <div id="file-preview-container" class="mt-4 space-y-2"> --}}
                    {{-- Pratinjau file baru akan muncul di sini --}}
                {{-- </div> --}}
            {{-- </div> --}}
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
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-lg focus:ring-2 focus:ring-yellow-500 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 flex items-center">
                    Kirim Ulang
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // const uploadButton = document.getElementById('upload-button');
    // const fileInput = document.getElementById('file_pendukung');
    // const filePreviewContainer = document.getElementById('file-preview-container');
    const uploadFileInput = document.getElementById('upload-file');
    const addFileButton = document.getElementById('add-file-button');
    const filePreviewContainer = document.getElementById('file-preview-container');

    let uploadedFiles = [];

    // Fungsi render preview file (hanya file baru)
    function renderFilePreview() {
        filePreviewContainer.innerHTML = '';
        uploadedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.classList.add('flex', 'items-center', 'justify-between', 'bg-gray-100', 'p-2', 'rounded-lg');

            const fileContent = document.createElement('div');
            fileContent.classList.add('flex', 'items-center', 'space-x-2');

            // Ikon file
            const fileIcon = document.createElement('span');
            fileIcon.classList.add('material-symbols-outlined', 'text-gray-500', 'text-lg');
            if (file.type.startsWith('image/')) {
                fileIcon.textContent = 'image';
            } else if (file.type === 'application/pdf') {
                fileIcon.textContent = 'picture_as_pdf';
            } else if (file.type.includes('word')) {
                fileIcon.textContent = 'description';
            } else if (file.type.includes('excel')) {
                fileIcon.textContent = 'grid_on';
            } else {
                fileIcon.textContent = 'attachment';
            }
            fileContent.appendChild(fileIcon);

            // Nama file
            const fileNameSpan = document.createElement('span');
            fileNameSpan.textContent = file.name;
            fileNameSpan.classList.add('text-sm', 'font-medium', 'text-blue-700', 'cursor-pointer', 'hover:underline');
            fileNameSpan.addEventListener('click', () => {
                const fileURL = URL.createObjectURL(file);
                window.open(fileURL, '_blank');
                URL.revokeObjectURL(fileURL);
            });
            fileContent.appendChild(fileNameSpan);

            // Tombol hapus
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

    // Event listener untuk tombol upload
    // uploadButton.addEventListener('click', () => {
    //     fileInput.click();
    // });
    addFileButton.addEventListener('click', () => {
    const file = uploadFileInput.files[0];
    if (file) {
        uploadedFiles.push(file);
        renderFilePreview();
        uploadFileInput.value = '';
    }
    });

    // Event listener untuk file input
    fileInput.addEventListener('change', () => {
        const files = Array.from(fileInput.files);
        if (files.length > 0) {
            uploadedFiles.push(...files);
            renderFilePreview();
            fileInput.value = ''; // Reset input
        }
    });

    // Jika mode edit, tampilkan file lama di container terpisah
    const transaksiLamaData = @json($transaksi ?? null);
    if (transaksiLamaData) {
        const fileLama = @json($fileLama ?? []);
        const fileLamaContainer = document.getElementById('file-lama-container');
        fileLama.forEach(file => {
            const fileItem = document.createElement('div');
            fileItem.classList.add('flex', 'items-center', 'justify-between', 'bg-blue-50', 'p-2', 'rounded');

            const fileContent = document.createElement('div');
            fileContent.classList.add('flex', 'items-center', 'space-x-2');

            // Ikon file
            const fileIcon = document.createElement('span');
            fileIcon.classList.add('material-symbols-outlined', 'text-gray-500', 'text-lg');
            if (file.file.endsWith('.png') || file.file.endsWith('.jpg') || file.file.endsWith('.jpeg')) {
                fileIcon.textContent = 'image';
            } else if (file.file.endsWith('.pdf')) {
                fileIcon.textContent = 'picture_as_pdf';
            } else {
                fileIcon.textContent = 'attachment';
            }
            fileContent.appendChild(fileIcon);

            // Nama file
            const fileNameSpan = document.createElement('span');
            fileNameSpan.textContent = file.file.split('/').pop(); // Ambil nama file saja
            fileNameSpan.classList.add('text-sm', 'font-medium', 'text-blue-700', 'cursor-pointer', 'hover:underline');
            fileNameSpan.addEventListener('click', () => {
                window.open(`{{ Storage::url('') }}${file.file}`, '_blank');
            });
            fileContent.appendChild(fileNameSpan);

            // Tombol hapus (opsional)
            const deleteButton = document.createElement('button');
            deleteButton.innerHTML = '<span class="material-symbols-outlined text-base text-red-500">close</span>';
            deleteButton.classList.add('p-1', 'rounded-full', 'hover:bg-gray-200');
            deleteButton.addEventListener('click', () => {
                // Jangan hapus file lama, hanya remove dari UI
                fileItem.remove();
            });

            fileItem.appendChild(fileContent);
            fileItem.appendChild(deleteButton);
            fileLamaContainer.appendChild(fileItem);
        });
    }
});

// Fungsi hapus file lama
function hapusFileLama(fileId, button) {
    if (confirm('Apakah Anda yakin ingin menghapus file ini?')) {
        fetch(`/api/hapus-file/${fileId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hapus elemen dari UI
                button.closest('div').remove();
                alert('File berhasil dihapus.');
            } else {
                alert('Gagal menghapus file.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus file.');
        });
    }
}
</script>
@endpush
@endsection
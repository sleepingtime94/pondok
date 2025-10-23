@extends('adminlte::page')

@section('title', 'Detail Transaksi - ' . $transaksi->id_trx)

@section('content_header')
    <h1>Detail Transaksi: {{ $transaksi->id_trx }}</h1>
@stop

@section('content')
<div class="container-fluid">
    <!-- Card Utama -->
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Informasi Transaksi</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <table class="table table-borderless" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td style="width: 180px; padding-right: 20px;"><strong>ID Transaksi</strong></td>
                                <td style="width: 20px;">:</td>
                                <td>{{ $transaksi->id_trx }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama</strong></td>
                                <td>:</td>
                                <td>{{ $transaksi->nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>NIK</strong></td>
                                <td>:</td>
                                <td>{{ $transaksi->nik }}</td>
                            </tr>
                            <tr>
                                <td><strong>No KK</strong></td>
                                <td>:</td>
                                <td>{{ $transaksi->kk ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Layanan</strong></td>
                                <td>:</td>
                                <td>{{ $transaksi->jenisPelayanan->nama ?? 'Lainnya' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <table class="table table-borderless" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td style="width: 180px; padding-right: 20px;"><strong>Tanggal Pengajuan</strong></td>
                                <td style="width: 20px;">:</td>
                                <td>{{ \Carbon\Carbon::parse($transaksi->tgl)->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td style="width: 180px; padding-right: 20px;"><strong>Tanggal Selesai</strong></td>
                                <td style="width: 20px;">:</td>
                                <td>
                                    {{ $transaksi->tgl_selesai ? \Carbon\Carbon::parse($transaksi->tgl_selesai)->format('d/m/Y H:i') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>:</td>
                                <td>
                                    <span class="badge {{ $transaksi->status_badge_class }}">
                                        {{ $transaksi->status_label }}
                                    </span>
                                    @if($transaksi->status == 4 && $transaksi->konfirmasi == 'Y')
                                        <span class="badge bg-success ml-1">Ter-Konfirmasi</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Keterangan</strong></td>
                                <td>:</td>
                                <td>{{ $transaksi->keterangan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pengambilan</strong></td>
                                <td>:</td>
                                <td>{{ $transaksi->pengambilan->nama ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Dokumen Persyaratan -->
    @if($transaksi->files?->isNotEmpty())
    <div class="card card-outline card-primary mt-4">
        <div class="card-header">
            <h3 class="card-title">Dokumen Persyaratan</h3>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($transaksi->files as $file)
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card shadow-sm border">
                            <a href="{{ asset($file->file) }}" target="_blank" class="d-block">
                                <img src="{{ asset($file->file) }}" 
                                    alt="Dokumen {{ $loop->index + 1 }}" 
                                    class="img-fluid w-100"
                                    onerror="this.src='{{ asset('dist/img/default-150x150.png') }}'"
                                    style="height: 150px; object-fit: contain; object-position: center; border-radius: 4px;">
                            </a>
                            <div class="card-body p-2 text-center">
                                <small class="text-muted d-block">{{ Str::limit(basename($file->file), 25) }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Card Update Status + Progress Vertikal -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Update Status</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.transaksi.update-status', $transaksi->id_trx) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="status">Pilih Status Baru :</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach(\App\Models\Transaksi::statusLabels() as $value => $label)
                                    <option value="{{ $value }}" {{ $transaksi->status == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Textarea Pesan Penolakan (muncul hanya saat pilih "Ditolak") -->
                        <div class="form-group mt-3" id="pesan-penolakan-container" style="display: none;">
                            <label for="pesan_penolakan">Pesan Penolakan <span class="text-danger">*</span></label>
                            <textarea name="pesan_penolakan" id="pesan_penolakan" class="form-control" rows="4" placeholder="Jelaskan alasan penolakan kepada pemohon..."></textarea>
                            <small class="text-muted">Pesan ini akan dikirim ke pemohon.</small>
                        </div>

                        {{-- Tampilkan Alasan Komplain JIKA ADA --}}
                        @if($transaksi->alasan)
                            <div class="row mt-4" id="komplain-alert" style="display: {{ $transaksi->status == 7 ? 'block' : 'none' }};">
                                <div class="col-12">
                                    <div class="alert alert-warning">
                                        <strong>Alasan Komplain dari Pemohon:</strong>
                                        <p class="mb-0 mt-2">{{ $transaksi->alasan }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group mt-1">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Respon Status
                            </button>
                            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
            
        <!-- Kolom Kanan: Progress Permohonan (Vertikal) -->
        <div class="col-md-4">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Progress Permohonan</h3>
                </div>
                <div class="card-body">
                    @if(count($timeline) > 0)
                        <div class="d-flex flex-column" style="gap: 20px;">
                            @foreach($timeline as $index => $item)
                                <div class="d-flex align-items-start" style="gap: 15px;">
                                    <!-- Icon -->
                                    <span class="badge bg-{{ $item['color'] }}" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                        <i class="fas fa-{{ $item['icon'] }} text-white"></i>
                                    </span>
                                    <!-- Detail -->
                                    <div>
                                        <div class="font-weight-bold">{{ $item['label'] }}</div>
                                        <div class="text-muted small">
                                            {{ $item['status_text'] }} • 
                                            {{ \Carbon\Carbon::parse($item['datetime'])->format('d/m/y H:i') }}
                                        </div>
                                        <!-- Durasi -->
                                        @if(isset($item['duration']) && $item['duration'] !== null && $index > 0)
                                            <div class="text-xs text-success mt-1">
                                                ({{ floor($item['duration'] / 60) }} jam {{ $item['duration'] % 60 }} menit)
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if(!$loop->last)
                                    <hr style="margin: 10px 0; border-top: 1px dashed #dee2e6;">
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center">Belum ada progress.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Dokumen Petugas -->
        <div class="col-md-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Dokumen Hasil</h3>
                </div>
                <div class="card-body">
                    <!-- Form Upload -->
                    <form action="{{ route('admin.dokumen.upload', $transaksi->id_trx) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_dokumen">Nama Dokumen:</label>
                            <input type="text" name="nama_dokumen" id="nama_dokumen" class="form-control" required placeholder="Contoh: Surat Keterangan">
                        </div>
                        <div class="form-group mt-3">
                            <label for="file">Unggah File PDF:</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".pdf" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="keterangan">Keterangan (Opsional):</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Jelaskan isi dokumen..."></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Unggah Dokumen
                            </button>
                        </div>
                    </form>

                    <!-- Daftar Dokumen -->
                    <hr>
                    <h5>Dokumen Terunggah:</h5>
                    @if($transaksi->userDokumen->isEmpty())
                        <p class="text-muted">Belum ada dokumen.</p>
                    @else
                        @foreach($transaksi->userDokumen as $dokumen)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <strong>{{ $dokumen->nama_dokumen }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $dokumen->created_at->format('d/m/Y H:i') }}</small>
                                        @if($dokumen->keterangan)
                                            <br><small>{{ $dokumen->keterangan }}</small>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('dokumen.show', $dokumen->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                        <form action="{{ route('admin.dokumen.delete', $dokumen->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus dokumen ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <iframe 
                                        src="{{ route('dokumen.show', $dokumen->file_path) }}" 
                                        width="100%" 
                                        height="350px"
                                        style="border: 1px solid #ddd; border-radius: 4px;">
                                        <p>Browser Anda tidak mendukung iframe PDF.</p>
                                    </iframe>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>  
    
</div>

@push('css')
    {{-- SweetAlert2 already loaded in app.blade.php --}}
@endpush

@push('js')
    {{-- SweetAlert2 already loaded in app.blade.php --}}
@endpush

<script>
(function() {
    function initStatusForm() {
        const statusSelect = document.getElementById('status');
        const penolakanContainer = document.getElementById('pesan-penolakan-container');
        const komplainAlert = document.getElementById('komplain-alert'); // ← ID baru

        if (!statusSelect) return;

        function toggleFields() {
            const selectedValue = statusSelect.value;
            
            // Toggle pesan penolakan (status 5)
            if (penolakanContainer) {
                penolakanContainer.style.display = (selectedValue === '5') ? 'block' : 'none';
            }

            // Toggle alert komplain (status 7)
            if (komplainAlert) {
                komplainAlert.style.display = (selectedValue === '7') ? 'block' : 'none';
            }
        }

        toggleFields();
        statusSelect.addEventListener('change', toggleFields);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initStatusForm);
    } else {
        initStatusForm();
    }
})();
</script>  

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        confirmButtonText: 'OK',
        timer: 3000,
        timerProgressBar: true
    });
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: "{{ session('error') }}",
    confirmButtonText: 'OK'
});
</script>
@endif

@endsection
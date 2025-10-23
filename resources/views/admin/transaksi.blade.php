@extends('adminlte::page')

@section('title', 'Admin - Transaksi')

@section('content_header')
    <!-- <h1>Manajemen Transaksi Permohonan</h1> -->
@stop

@section('content')
<div class="container-fluid">
    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filter Data</h5>
        </div>
        <div class="card-body">
            <form method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                @foreach(\App\Models\Transaksi::statusLabels() as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col-md-3">
                        <label>Jenis Dokumen</label>
                        <select name="filter_jenis" class="form-control">
                            <option value="">Semua Jenis</option>
                            @foreach($filterGroups as $group => $keyword)
                                <option value="{{ $group }}" {{ request('filter_jenis') == $group ? 'selected' : '' }}>
                                    {{ $group }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Tgl. Dari</label>
                        <input type="date" name="tgl_dari" class="form-control" value="{{ request('tgl_dari') }}">
                    </div>
                    <div class="col-md-2">
                        <label>Tgl. Sampai</label>
                        <input type="date" name="tgl_sampai" class="form-control" value="{{ request('tgl_sampai') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary ml-2">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><b>DAFTAR PERMOHONAN</b></h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID TRX</th>
                        <th>Nama & NIK</th>
                        <th>Jenis Layanan</th>
                        <th>Progress Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                        <tr>
                            <td>
                                <div><strong>{{ $t->id_trx }}</strong></div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($t->tgl)->format('d-m-Y H:i') }}</small>
                            </td>
                            <td>
                                <div><strong>{{ $t->nama }}</strong></div>
                                <small class="text-muted">{{ $t->nik }}</small>
                            </td>
                            <td>{{ $t->jenisPelayanan->nama ?? 'Lainnya' }}</td>
                            <td>
                                <span class="badge {{ $t->status_badge_class }}">
                                    {{ $t->status_label }}
                                </span>

                                @if($t->status == 4 && $t->konfirmasi == 'Y')
                                    <span class="badge bg-success ml-1">Ter-Konfirmasi</span>
                                @endif

                                <br>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($t->tgl)->format('d-m-Y H:i') }}
                                </small>
                            </td>
                            <td>
                                <a href="{{ route('admin.transaksi.show', $t->id_trx) }}" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $transaksis->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
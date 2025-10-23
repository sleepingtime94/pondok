@extends('adminlte::page')

@section('title', 'Edit Jadwal - ' . $jadwal->hari)

@section('content_header')
    <h1>Edit Jadwal: {{ $jadwal->hari }}</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Jadwal</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="jam_buka">Jam Buka</label>
                            <input type="time" name="jam_buka" id="jam_buka" class="form-control" value="{{ old('jam_buka', $jadwal->jam_buka) }}" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="jam_tutup">Jam Tutup</label>
                            <input type="time" name="jam_tutup" id="jam_tutup" class="form-control" value="{{ old('jam_tutup', $jadwal->jam_tutup) }}" required>
                        </div>

                        <div class="form-group mt-3">
                            <div class="form-check">
                                <input type="checkbox" name="aktif" id="aktif" class="form-check-input" value="1" {{ old('aktif', $jadwal->aktif) ? 'checked' : '' }}>
                                <label for="aktif" class="form-check-label">Aktifkan Hari Ini</label>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
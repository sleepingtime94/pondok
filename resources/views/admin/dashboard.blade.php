@extends('adminlte::page')

@section('title', 'Dashboard Admin - Pondok')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
@if($transaksiBaruCount ?? 0 > 0)
<div class="container-fluid">
    <div class="alert alert-warning alert-dismissible">
        <h5><i class="icon fas fa-exclamation-triangle"></i> Perhatian!</h5>
        Ada <strong>{{ $transaksiBaruCount }}</strong> permohonan baru menunggu verifikasi.
        <a href="{{ route('admin.transaksi.index', ['status' => 1]) }}" class="btn btn-sm btn-primary">Cek Sekarang !</a>
    </div>
</div>
@endif

<div class="container-fluid">
    <div class="row">
        {{-- Bagian Info Boxes --}}

        {{-- 1. New Orders (Info Box Biru) --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $newOrdersToday }}</h3>
                    <p>Permohonan Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <a href="{{ route('admin.transaksi.index', ['created_at' => now()->toDateString()]) }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- 2. Bounce Rate (Info Box Hijau) --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>
                    <p>Bounce Rate</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- 3. User Registrations (Info Box Kuning) --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>44</h3>
                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- 4. Unique Visitors (Info Box Merah) --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>
                    <p>Unique Visitors</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Kolom Kiri: Sales Chart --}}
        <section class="col-lg-7 connectedSortable">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Sales</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </section>

        {{-- Kolom Kanan: Visitors Map --}}
        <section class="col-lg-5 connectedSortable">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Visitors</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="world-map" style="height: 300px; width: 100%;">[Isi Peta JQVMap di sini]</div>
                </div>
            </div>
        </section>
    </div>

    {{-- Baris Ketiga (Chat & Graph Lain) dapat ditambahkan di sini --}}

</div>
@stop

{{-- ... section CSS dan JS --}}

@extends('layouts.app')
@section('content')

    <div class="max-w-4xl mx-auto p-4 pb-20">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Daftar Permohonan</h1>

        <div class="bg-white rounded-lg shadow-xl p-6">
            @if ($orders->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach ($orders as $order)
                        <li class="py-4">
                            <a href="{{ route('tracking.show', $order->id_trx) }}" class="block hover:bg-gray-50 transition-colors duration-200 rounded-lg p-4 -m-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-lg font-bold text-gray-800">
                                            ID : <span class="font-bold text-blue-800">{{ $order->id_trx }}</span>
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Status : 
                                            <span class="font-bold 
                                                @if ($order->status == '4')
                                                    text-green-600
                                                @elseif ($order->status == '3')
                                                    text-blue-600
                                                @elseif ($order->status == '2') 
                                                    text-gray-500
                                                @elseif ($order->status == '5') 
                                                    text-red-600
                                                @else
                                                    text-red-600
                                                @endif
                                            ">
                                                @if ($order->status == '4')
                                                    SELESAI
                                                @elseif ($order->status == '3')
                                                    DIPROSES
                                                @elseif ($order->status == '2')
                                                    VERIFIKASI
                                                @elseif ($order->status == '5')
                                                    DITOLAK
                                                @elseif ($order->status == '6')
                                                    PENGAJUAN ULANG
                                                @elseif ($order->status == '7')
                                                    KOMPLAIN
                                                @elseif ($order->status == '8')
                                                    DIBATALKAN
                                                @else
                                                    BARU
                                                @endif
                                            </span><br>
                                            Permohonan : <span class="font-bold italic">{{ $order->dokumen->nama ?? 'Nama Layanan Tidak Ditemukan' }}</span>
                                        </p>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center p-8 text-gray-500">
                    <p class="mt-4">Anda belum memiliki permohonan yang dilacak.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

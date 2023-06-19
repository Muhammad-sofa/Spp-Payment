@extends('layouts.app_sneat_blank')
@section('content')
<script type="text/javascript">
    window.print();
</script>
<div class="container mt-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-8">
                <div class="p-3 bg-white rounded">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="text-uppercase">KWITANSI PEMBAYARAN</h1>
                            <div class="billed"><span class="font-weight-bold">Nama Sekolah : </span><span class="ml-1">SMAN 1 Wonoayu</span></div>
                            <div class="billed"><span class="font-weight-bold">Tanggal Pembayaran : </span><span class="ml-1">{{ $pembayaran->tanggal_pembayaran->translatedFormat('d F Y') }}</span></div>
                            <div class="billed"><span class="font-weight-bold">Pembayaran ID : </span><span class="ml-1">Smaniwa-{{ $pembayaran->id }}</span></div>
                        </div>
                    <div class="mt-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Metode Bayar</th>
                                        <th>Jumlah Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>{{ $pembayaran->tanggal_pembayaran->translatedFormat('d/m/Y') }}</td>
                                            <td>{{ formatRupiah($pembayaran->jumlah_dibayar) }}</td>
                                            <td>{{ $pembayaran->metode_pembayaran }}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-right mb-3">
                        <i>Terbilang : {{ ucwords(terbilang($pembayaran->jumlah_dibayar) )}}</i>
                    </div>
                    <div>
                        Sidoarjo, {{ $pembayaran->tanggal_pembayaran->translatedFormat('d F Y') }}
                        <br><br><br>
                        <u>{{ $pembayaran->user->name }}</u>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

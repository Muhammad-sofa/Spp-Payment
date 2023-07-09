@extends('layouts.app_sneat_wali')
@section('js')
<script>
    $(document).ready(function() {
            $("#pilih_bank").change(function(e) {
                var bankId = $(this).find(":selected").val();
                window.location.href = "{!! $url !!}&bank_sekolah_id=" + bankId;
            });
        });
</script>
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">KONFIRMASI PEMBAYARAN</h5>
            <div class="card-body">
                {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}
                <h6 class="m-0 p-0"><i class="fa fa-info-circle"></i> INFORMASI REKENING PENGIRIM</h6>

                <div class="informasi-pengirim">
                    <div class="alert alert-dark" role="alert">
                        Informasi ini dibutuhkan agar operator sekolah dapat memverifikasi pembayaran yang dilakukan oleh wali murid melalui bank.
                    </div>
                    <div class="form-group">
                        <label for="nama_bank_pengirim">Nama Bank Pengirim</label>
                        {!! Form::select('bank_id', $listBank, null, ['class' => 'form-control select2']) !!}
                        <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                    </div>

                    <div class="form-group mt-3">
                        <label for="rekening_bank_pengirim">Nama Pemilik Rekening</label>
                        {!! Form::text('rekening_bank_pengirim', null, ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('rekening_bank_pengirim') }}</span>
                    </div>

                    <div class="form-group mt-3">
                        <label for="no_rekening_bank_pengirim">Nomor Rekening</label>
                        {!! Form::text('no_rekening_bank_pengirim', null, ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('no_rekening_bank_pengirim') }}</span>
                    </div>
                </div>

                <h6 class="m-0 p-0 mt-4 mb-0 pb-0">
                    <i class="fa fa-info-circle"></i> INFORMASI REKENING TUJUAN
                </h6>

                <div class="informasi-bank-tujuan">
                    <div class="form-group mt-0">
                        <label for="bank_id">Bank Tujuan Pembayaran</label>
                        {!! Form::select('bank_id', $listBankSekolah, request('bank_sekolah_id'), [
                        'class' => 'form-control',
                        'placeholder' => 'Pilih Bank Tujuan Transfer',
                        'id' => 'pilih_bank',
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                    </div>
                    @if (request('bank_sekolah_id') != '')
                    <div class="alert alert-dark mt-3" role="alert">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="15%">Bank Tujuan</td>
                                    <td>: {{ $bankYangDipilih->nama_bank }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Rekening</td>
                                    <td>: {{ $bankYangDipilih->nomor_rekening }}</td>
                                </tr>
                                <tr>
                                    <td>Atas Nama</td>
                                    <td>: {{ $bankYangDipilih->nama_rekening }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                <h6 class="m-0 p-0 mt-4 mb-0 pb-0">
                    <i class="fa fa-info-circle"></i> INFORMASI PEMBAYARAN
                </h6>
                <div class="informasi-pembayaran">
                    <div class="form-group mt-0">
                        <label for="tanggal_bayar">Tanggal Bayar</label>
                        {!! Form::date('tanggal_bayar', $model->tanggal_bayar ?? date('Y-m-d'), ['class' =>
                        'form-control'])
                        !!}
                        <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                    </div>
                    {!! Form::close() !!}

                    <div class="form-group mt-3">
                        <label for="jumlah_dibayar">Jumlah yang dibayarkan</label>
                        {!! Form::text('jumlah_dibayar', null, ['class' => 'form-control rupiah']) !!}
                        <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
                    </div>

                    <div class="form-group mt-3">
                        <label for="bukti_bayar">Kwitansi</label>
                        {!! Form::file('bukti_bayar', ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('bukti_bayar') }}</span>
                    </div>
                </div>
                {!! Form::submit('SIMPAN', ['class' => 'btn btn-primary mt-3']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
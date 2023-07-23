@extends('layouts.app_sneat')
@section('content')
<div class="row justify-content-center">
     <div class="col-md-12">
          <div class="card">
               <h5 class="card-header">DATA TAGIHAN SPP SISWA {{ strtoupper($periode) }}</h5>
               <div class="card-body">
                    <table class="table table-sm">
                         <tr>
                              <td rowspan="8" width="100">
                                   <img src="{{ \Storage::url($siswa->foto) }}" alt="{{ $siswa->nama }}" width="200">
                              </td>
                         </tr>
                         <tr>
                              <td width="50">NISN</td>
                              <td>: {{ $siswa->nisn }}</td>
                         </tr>
                         <tr>
                              <td>Nama</td>
                              <td>: {{ $siswa->nama }}</td>
                         </tr>
                    </table>
                         <a href="{{ route('kartuspp.index', [
                              'siswa_id' => $siswa->id,
                              'tahun' => request('tahun'),
                              ]) }}" class="btn btn-primary btn-sm" target="blank"><i class="fa fa-file"></i> Kartu Tagihan {{ request('tahun') }}</a>
               </div>
          </div>
     </div>
</div>
<div class="row mt-3">
     <div class="col-md-5">
          <div class="card">
               <h5 class="card-header pb-1">DATA TAGIHAN {{ strtoupper($periode) }}</h5>
               <div class="card-body">
                    <table class="table table-sm table-bordered">
                         <thead>
                              <tr>
                                   <th>No</th>
                                   <th>Nama Tagihan</th>
                                   <th>Jumlah Tagihan</th>
                              </tr>
                         </thead>
                         <tbody>
                              @foreach ($tagihan->tagihanDetails as $item)
                                   <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_biaya }}</td>
                                        <td>{{ formatRupiah($item->jumlah_biaya) }}</td>
                                   </tr>
                              @endforeach
                         </tbody>
                         <tfoot>
                              <tr>
                                   <td colspan="2">Total Pembayaran</td>
                                   <td>{{ formatRupiah($tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                              </tr>
                         </tfoot>
                    </table>
               </div>
          </div>
                    <div class="card">
               <h5 class="card-header pb-1">DATA PEMBAYARAN</h5>
               <div class="card-body">
                    <table class="table table-striped table-bordered">
                         <thead>
                              <tr>
                                   <th>#</th>
                                   <th>TANGGAL</th>
                                   <th>JUMLAH</th>
                                   <th>METODE</th>
                              </tr>
                         </thead>
                         <tbody>
                              @foreach ($tagihan->pembayaran as $item)
                              <tr>
                                   <td>
                                        <a href="{{ route('kwitansipembayaran.show', $item->id) }}" target="blank"><i class="fa fa-print"></i></a>
                                   </td>
                                   <td>{{ optional($item->tanggal_bayar)->translatedFormat('d/m/Y') }}</td>
                                   <td>{{ formatRupiah($item->jumlah_dibayar) }}</td>
                                   <td>{{ $item->metode_pembayaran }}</td>
                              </tr>
                              @endforeach
                         </tbody>
                    </table>
                    <h5 class="mt-3">Status Pembayaran : {{ strtoupper($tagihan->status) }}</h5>
               </div>
               <h5 class="card-header">FORM PEMBAYARAN</h5>
               <div class="card-body">
                         {!! Form::model($model, ['route' => 'pembayaran.store', 'method' => 'POST']) !!}
                         {!! Form::hidden('tagihan_id', $tagihan->id, []) !!}
               <div class="form-group">
                    <label for="tanggal_bayar">tanggal_bayar</label>
                         {!! Form::date('tanggal_bayar', $model->tanggal_bayar ?? \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
                    <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
               </div>

               <div class="form-group mt-3">
                    <label for="jumlah_dibayar">Jumlah Yang Dibayarkan</label>
                         {!! Form::text('jumlah_dibayar', null, ['class' => 'form-control rupiah']) !!}
                    <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
               </div>
                         {!! Form::submit('SIMPAN', ['class' => 'btn btn-primary mt-3']) !!}
                         {!! Form::close() !!}
               </div>
          </div>
     </div>
     <div class="col-md-7">

     </div>
</div>
@endsection

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
               </div>
          </div>
     </div>
</div>
<div class="row mt-3">
     <div class="col-md-5">
          <div class="card">
               <h5 class="card-header">DATA TAGIHAN</h5>
               <div class="card-body">
                    Data Tagihan
               </div>
          </div>
     </div>
     <div class="col-md-7">
          <div class="card">
               <h5 class="card-header">KARTU SPP</h5>
               <div class="card-body">
                    Kartu spp
               </div>
          </div>
     </div>
</div>
@endsection

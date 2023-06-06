@extends('layouts.app_sneat')
@section('content')
<div class="row justify-content-center">
     <div class="col-md-12">
          <div class="card">
               <h5 class="card-header">{{ $title }}</h5>
               <div class="card-body">
                    <div class="table-responsive">
                         <img src="{{ \Storage::url($model->foto ?? 'image/no-image.png') }}" width="150">
                         <table class="table table-striped table-sm">
                              <thead>
                                   <tr>
                                        <td width="15%">ID</td>
                                        <td>: {{ $model->id }}</td>
                                   </tr>
                                   <tr>
                                        <td>Nama</td>
                                        <td>: {{ $model->nama }}</td>
                                   </tr>
                                   <tr>
                                        <td>NISN</td>
                                        <td>: {{ $model->nisn }}</td>
                                   </tr>
                                   <tr>
                                        <td>Jurusan</td>
                                        <td>: {{ $model->jurusan }}</td>
                                   </tr>
                                   <tr>
                                        <td>Kelas</td>
                                        <td>: {{ $model->kelas }}</td>
                                   </tr>
                                   <tr>
                                        <td>Angkatan</td>
                                        <td>: {{ $model->angkatan }}</td>
                                   </tr>
                                   <tr>
                                        <td>Tgl Buat</td>
                                        <td>: {{ $model->created_at->format('d/m/Y H:i') }}</td>
                                   </tr>
                                   <tr>
                                        <td>Tgl Ubah</td>
                                        <td>: {{ $model->updated_at->format('d/m/Y H:i') }}</td>
                                   </tr>
                                   <tr>
                                        <td>Dibuat Oleh</td>
                                        <td>: {{ $model->user->name }}</td>
                                   </tr>
                              </thead>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>
@endsection

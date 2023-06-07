@extends('layouts.app_sneat')
@section('content')
<div class="row justify-content-center">
     <div class="col-md-12">
          <div class="card">
               <h5 class="card-header">{{ $title }}</h5>
               <div class="card-body">
                    <div class="table-responsive">
                         <table class="table table-striped table-sm">
                              <thead>
                                   <tr>
                                        <td width="15%">ID</td>
                                        <td>: {{ $model->id }}</td>
                                   </tr>
                                   <tr>
                                        <td>Nama</td>
                                        <td>: {{ $model->name }}</td>
                                   </tr>
                                   <tr>
                                        <td>Email</td>
                                        <td>: {{ $model->email }}</td>
                                   </tr>
                                   <tr>
                                        <td>No HP</td>
                                        <td>: {{ $model->nohp }}</td>
                                   </tr>
                                   <tr>
                                        <td>Tgl Buat</td>
                                        <td>: {{ $model->created_at->format('d/m/Y H:i') }}</td>
                                   </tr>
                                   <tr>
                                        <td>Tgl Ubah</td>
                                        <td>: {{ $model->updated_at->format('d/m/Y H:i') }}</td>
                                   </tr>
                              </thead>
                         </table>
                         <h4 class="my-3">Tambah Data Anak</h4>
                         {!! Form::open(['route' => 'walisiswa.store', 'method' => 'POST']) !!}
                         {!! Form::hidden('wali_id', $model->id, []) !!}
                              <div class="form-group">
                                   <label for="siswa_id">Pilih Data Siswa</label>
                                        {!! Form::select('siswa_id', $siswa, null, ['class' => 'form-control select2']) !!}
                                        <span class="text-danger">{{ $errors->first('siswa_id') }}</span>
                              </div>
                         {!! Form::submit('SIMPAN', ['class' => 'btn btn-primary my-2']) !!}
                         {!! Form::close() !!}
                         <h4 class="my-3">DATA ANAK</h4>
                         <table class="table table-light">
                              <thead>
                                   <tr>
                                        <th>No</th>
                                        <th>NISN</th>
                                        <th>Nama</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   @foreach ($model->siswa as $item)
                                        <tr>
                                             <td>{{ $loop->iteration }}</td>
                                             <td>{{ $item->nisn }}</td>
                                             <td>{{ $item->nama }}</td>
                                        </tr>
                                   @endforeach
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>
@endsection

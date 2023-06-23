@extends('layouts.app_sneat_wali')
@section('content')
<div class="row justify-content-center">
     <div class="col-md-12">
          <div class="card">
               <h5 class="card-header">DATA SISWA</h5>
               <div class="card-body">
                    <a href="" class="btn btn-primary btn-sm">Tambah Data</a>
                    <div class="table-responsive">
                         <table class="table table-striped ">
                              <thead>
                                   <tr>
                                        <th>No</th>
                                        <th>Nama Wali Murid</th>
                                        <th>Nama</th>
                                        <th>NISN</th>
                                        <th>Jurusan</th>
                                        <th>Kelas</th>
                                        <th>Angkatan</th>
                                        <th>Created By</th>
                                        <th>Aksi</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   @forelse ($models as $item)
                                        <tr>
                                             <td>{{ $loop->iteration }}</td>
                                             <td>{{ $item->wali->name }}</td>
                                             <td>{{ $item->nama }}</td>
                                             <td>{{ $item->nisn }}</td>
                                             <td>{{ $item->jurusan }}</td>
                                             <td>{{ $item->kelas }}</td>
                                             <td>{{ $item->angkatan }}</td>
                                             <td>{{ $item->user->name }}</td>
                                             <td></td>
                                        </tr>
                                   @empty
                                        <tr>
                                             <td colspan="4">Data tidak ada</td>
                                        </tr>
                                   @endforelse
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>
@endsection

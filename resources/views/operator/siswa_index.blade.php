@extends('layouts.app_sneat')
@section('content')
<div class="row justify-content-center">
     <div class="col-md-12">
          <div class="card">
               <h5 class="card-header">{{ $title }}</h5>
               <div class="card-body">
                    <a href="{{ route($routePrefix.'.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
                    <div class="table-responsive">
                         <table class="table table-striped">
                              <thead>
                                   <tr>
                                        <th>No</th>
                                        <th>Nama Wali Murid</th>
                                        <th>Nama</th>
                                        <th>NISN</th>
                                        <th>Jurusan</th>
                                        <th>Kelas</th>
                                        <th>Angkatan</th>
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
                                             <td>
                                                  {!! Form::open([
                                                       'route' => [$routePrefix .'.destroy', $item->id],
                                                       'method' => 'DELETE',
                                                       'onsubmit' => 'return confirm("Yakin ingin menghapus data ini ?")',
                                                  ]) !!}
                                                  <a href="{{ route($routePrefix.'.edit', $item->id) }}" class="btn btn-warning btn-sm ml-2 mr-2">
                                                       <i class="fa fa-edit"></i> Edit
                                                  </a>

                                                  <a href="{{ route($routePrefix.'.show', $item->id) }}" class="btn btn-info btn-sm">
                                                       <i class="fa fa-edit"></i> Detail
                                                  </a>
                                                       {{-- {!! Form::submit('Hapus', ['class' => 'btn btn-danger btn-sm']) !!} --}}
                                                       <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i> Delete
                                                       </button>
                                                  {!! Form::close() !!}
                                             </td>
                                        </tr>
                                   @empty
                                        <td colspan="4">Data tidak ada</td>
                                   @endforelse
                              </tbody>
                         </table>
                         {!! $models->links() !!}
                    </div>
               </div>
          </div>
     </div>
</div>
@endsection

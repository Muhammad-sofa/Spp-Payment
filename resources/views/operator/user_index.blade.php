@extends('layouts.app_sneat')
@section('content')
<div class="row justify-content-center">
     <div class="col-md-12">
          <div class="card">
               <h5 class="card-header">Data User</h5>
               <div class="card-body">
                    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
                    <div class="table-responsive">
                         <table class="table table-striped">
                              <thead>
                                   <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>No.Hp</th>
                                        <th>Email</th>
                                        <th>Akses</th>
                                        <th>Aksi</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   @forelse ($models as $item)
                                        <tr>
                                             <td>{{ $loop->iteration }}</td>
                                             <td>{{ $item->name }}</td>
                                             <td>{{ $item->nohp }}</td>
                                             <td>{{ $item->email }}</td>
                                             <td>{{ $item->akses }}</td>
                                             <td>
                                                  {!! Form::open([
                                                       'route' => ['user.destroy', $item->id],
                                                       'method' => 'DELETE',
                                                       'onsubmit' => 'return confirm("Yakin ingin menghapus data ini ?")',
                                                  ]) !!}
                                                  <a href="{{ route('user.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                       <i class="fa fa-edit"></i> Edit
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

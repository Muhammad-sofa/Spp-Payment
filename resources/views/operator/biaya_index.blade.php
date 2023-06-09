@extends('layouts.app_sneat')
@section('content')
<div class="row justify-content-center">
     <div class="col-md-12">
          <div class="card">
               <h5 class="card-header">{{ $title }}</h5>
               <div class="card-body">
                    <a href="{{ route($routePrefix.'.create') }}" class="btn btn-primary btn-sm mb-3">Tambah Data</a>
                    {!! Form::open(['route' => $routePrefix . '.index', 'method' => 'GET']) !!}
                         <div class="input-group">
                              <input name="q" type="text" class="form-control" placeholder="Cari Data"
                                   aria-label="cari nama" aria-describedby="button-addon2" value="{{ request('q') }}">
                              <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                   <i class="bx bx-search"></i>
                              </button>
                         </div>
                    {{ !!Form::close() }}
                    <div class="table-responsive">
                         <table class="table table-striped">
                              <thead>
                                   <tr>
                                        <th>No</th>
                                        <th>Nama Biaya</th>
                                        <th>Jumlah</th>
                                        <th>Created By</th>
                                        <th>Aksi</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   @forelse ($models as $item)
                                        <tr>
                                             <td>{{ $loop->iteration }}</td>
                                             <td>{{ $item->nama }}</td>
                                             <td>{{ formatRupiah($item->jumlah) }}</td>
                                             <td>{{ $item->user->name }}</td>
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

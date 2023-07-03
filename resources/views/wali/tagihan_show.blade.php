@extends('layouts.app_sneat_wali')
@section('content')
<div class="row justify-content-center">
     <div class="col-md-12">
          <div class="card">
               <h5 class="card-header">TAGIHAN SPP {{ strtoupper($siswa->nama) }}</h5>
               <div class="card-body">
                    <table class="table table-sm table-bordered">
                         <thead>
                              <tr>
                                   <th width="1%">No</th>
                                   <th>Nama Tagihan</th>
                                   <th class="text-end">Jumlah Tagihan</th>
                              </tr>
                         </thead>
                         <tbody>
                              @foreach ($tagihan->tagihanDetails as $item)
                              <tr>
                                   <td>{{ $loop->iteration }}</td>
                                   <td>{{ $item->nama_biaya }}</td>
                                   <td class="text-end">{{ formatRupiah($item->jumlah_biaya) }}</td>
                              </tr>
                              @endforeach
                         </tbody>
                         <tfoot>
                              <tr>
                                   <td colspan="2" class="text-center fw-bold">Total Pembayaran</td>
                                   <td class="text-end fw-bold">{{ formatRupiah($tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                              </tr>
                         </tfoot>
                    </table>
                    <div class="alert alert-secondary mt-4" role="alert" style="color:black">
                         Pembayaran bisa dilakukan dengan cara langsung ke operator sekolah atau ditransfer melalui rekening berikut :
                         <br>
                         <div style="color: red">
                              Jangan melakukan transfer ke rekening selain dari rekening dibawah ini.
                         </div>
                    </div>
                    <ul>
                         <li><a href="http://">Cara Pembayaran Melalui ATM</a></li>
                         <li><a href="http://">Cara Pembayaran Melalui Internet Banking</a></li>
                    </ul>
                    Setelah melakukan pembayaran, Silahkan upload bukti pembayaran melalui tombol konfirmasi yang ada dibawah ini:
                    <div class="row">
                         @foreach ($bankSekolah as $itemBank)
                         <div class="col-md-6">
                              <div class="alert alert-info" role="alert" width="100%">
                                   <table width="100%">
                                   <tbody>
                                        <tr>
                                             <td width="30%">Bank Tujuan</td>
                                             <td>: {{ $itemBank->nama_bank }}</td>
                                        </tr>
                                        <tr>
                                             <td>Nomor Rekening</td>
                                             <td>: {{ $itemBank->nomor_rekening }}</td>
                                        </tr>
                                        <tr>
                                             <td>Atas Nama</td>
                                             <td>: {{ $itemBank->nama_rekening }}</td>
                                        </tr>
                                   </tbody>
                              </table>
                              <a href="" class="btn btn-primary btn-sm mt-3">Konfirmasi Pembayaran</a>
                              </div>
                         </div>
                         @endforeach
                    </div>

               </div>
          </div>
     </div>
</div>
@endsection

<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\BankSekolah;
use App\Models\User;
use App\Models\WaliBank;
use App\Notifications\PembayaranNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Notification;

class WaliMuridPembayaranController extends Controller
{
    public function create(Request $request)
    {
        $data['listWaliBank'] = WaliBank::where('wali_id', Auth::user()->id)->get()->pluck('nama_bank_full', 'id');
        $data['tagihan'] = Tagihan::waliSiswa()->findOrFail($request->tagihan_id);
        $data['model'] = new Pembayaran();
        $data['method'] = 'POST';
        $data['route'] = 'wali.pembayaran.store';
        $data['listBankSekolah'] = BankSekolah::pluck('nama_bank', 'id');
        $data['listBank'] = Bank::pluck('nama_bank', 'id');
        if ($request->bank_sekolah_id != '') {
            $data['bankYangDipilih'] = BankSekolah::findOrFail(
                $request->bank_sekolah_id
            );
        }
        $data['url'] = route('wali.pembayaran.create', [
            'tagihan_id' => $request->tagihan_id,
        ]);

        return view('wali.pembayaran_form', $data);
    }

    public function store(Request $request) 
    {
        $pilihanBank = $request->pilihan_bank;
        if($request->filled('pilihan_bank')){
            //wali buat rekening baru
            $bankId = $request->bank_id;
            $bank = Bank::findOrFail($bankId);
            if($request->filled('simpan_data_rekening')){
                //validasi data
                $requestDataBank = $request->validate([
                    'nama_rekening' => 'required',
                    'nomor_rekening' => 'required',
                ]);

                //ketika buat baru kondisi data sudah ada maka tidak akan di timpa datanya
                $waliBank = WaliBank::firstOrCreate(
                    $requestDataBank,
                    [
                        'nama_rekening' => $requestDataBank['nama_rekening'],
                        'wali_id' => Auth::user()->id,
                        'kode' => $bank->nama_bank,
                        'nama_bank' => $bank->nama_bank,
                    ]
                );
            }
        }else{
            //ambil data walibank dari database
            $waliBankId = $request->wali_bank_id;
            $waliBank = WaliBank::findOrFail($waliBankId);
        }
        $request->validate([
            'tanggal_bayar' => 'required',
            'jumlah_dibayar' =>'required',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);
        $buktiBayar = $request->file('bukti_bayar')->store('public');
        $dataPembayaran = [
            'bank_sekolah_id' => $request->bank_sekolah_id,
            'wali_bank_id' => $waliBank->id,
            'tagihan_id' => $request->tagihan_id,
            'wali_id' => auth()->user()->id,
            'tanggal_bayar' => $request->tanggal_bayar,
            'status_konfirmasi' => 'belum',
            'jumlah_dibayar' => str_replace('.', '', $request->jumlah_dibayar),
            'bukti_bayar' => $buktiBayar,
            'metode_pembayaran' => 'transfer',
            'user_id' => 0,
        ];
        $pembayaran = Pembayaran::create($dataPembayaran);
        $userOperator = User::where('akses', 'operator')->get();
        Notification::send($userOperator, new PembayaranNotification($pembayaran));
        flash('Pembayaran berhasil disimpan dan akan segera dikonfirmasi oleh operator')->success();
        return back();    
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\BankSekolah;
use Illuminate\Http\Request;

class WaliMuridPembayaranController extends Controller
{
    public function create(Request $request)
    {
        $data['tagihan'] = Tagihan::waliSiswa()->findOrFail($request->tagihan_id);
        $data['model'] = new Pembayaran();
        $data['method'] = 'POST';
        $data['route'] = 'wali.pembayaran.store';
        $data['listBank'] = BankSekolah::pluck('nama_bank', 'id');
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
}

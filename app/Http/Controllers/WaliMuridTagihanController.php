<?php

namespace App\Http\Controllers;

use App\Models\BankSekolah;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridTagihanController extends Controller
{
    public function index()
    {
        $siswaId = Auth::user()->getAllSiswaId();
        $data['tagihan'] = Tagihan::whereIn('siswa_id', $siswaId)->get();
        return view('wali.tagihan_index', $data);
    }

    public function show($id)
    {
        $siswaId = Auth::user()->getAllSiswaId();
        $tagihan = Tagihan::whereIn('siswa_id', $siswaId)->findOrFail($id);
        $data['bankSekolah'] = BankSekolah::all();
        $data['tagihan'] = $tagihan;
        $data['siswa'] = $tagihan->siswa;
        return view('wali.tagihan_show', $data);
    }
}

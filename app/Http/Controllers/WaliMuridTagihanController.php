<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridTagihanController extends Controller
{
    public function index()
    {
        $siswaId = Auth::user()->siswa->pluck('id');
        $tagihan = Tagihan::whereIn('siswa_id', $siswaId)->get();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\Tagihan as Model;
use App\Http\Requests\StoreTagihanRequest;
use App\Http\Requests\UpdateTagihanRequest;
use App\Models\Tagihan;
use Carbon\Carbon;

class TagihanController extends Controller
{
    private $viewIndex = 'tagihan_index';
    private $viewCreate = 'tagihan_form';
    private $viewEdit = 'tagihan_form';
    private $viewShow = 'tagihan_show';
    private $routePrefix = 'tagihan';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $models = Model::with('user', 'siswa')->groupBy('siswa_id')->latest()
                ->whereMonth('tanggal_tagihan', $request->bulan)
                ->whereYear('tanggal_tagihan', $request->tahun)
                ->paginate(50);
        }else{
            $models = Model::with('user', 'siswa')->groupBy('siswa_id')->latest()->paginate(50);
        }
        return view('operator.'.$this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Tagihan'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $siswa = Siswa::all();
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix.'.store',
            'button' => 'SIMPAN',
            'title' => 'Form Data Tagihan',
            'angkatan' => $siswa->pluck('angkatan', 'angkatan'),
            'kelas' => $siswa->pluck('kelas', 'kelas'),
            'biaya' => Biaya::get(),
        ];
        return view('operator.'.$this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagihanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagihanRequest $request)
    {
        //1. Lakukan validasi
        //2. Ambil data biaya yang ditagihkan
        //3. Ambil data siswa yang ditagih berdasarkan kelas atau berdasarkan angkatan
        //4. Lakukan perulangan berdasarkan data siswa
        //5. Didalam perulangan, simpan tagihan berdasarkan biaya dan siswa
        //6. Simpan notifikasi database untuk tagihan
        //7. Kirim pesan whatsapp
        //8. Redirect back() dengan pesan sukses
        $requestData = $request->validated();
        $biayaIdArray = $requestData['biaya_id'];

        $siswa = Siswa::query();

        if ($requestData['kelas'] != ''){
            $siswa->where('kelas', $requestData['kelas']);
        }
        if ($requestData['angkatan'] != ''){
            $siswa->where('angkatan', $requestData['angkatan']);
        }
        $siswa = $siswa->get();
        foreach ($siswa as $item) {
            $itemSiswa = $item;
            $biaya = Biaya::whereIn('id', $biayaIdArray)->get();
            foreach ($biaya as $itemBiaya) {
                $dataTagihan = [
                    'siswa_id' => $itemSiswa->id,
                    'angkatan' => $requestData['angkatan'],
                    'kelas' => $requestData['kelas'],
                    'tanggal_tagihan' => $requestData['tanggal_tagihan'],
                    'tanggal_jatuh_tempo' => $requestData['tanggal_jatuh_tempo'],
                    'nama_biaya' => $itemBiaya->nama,
                    'jumlah_biaya' => $itemBiaya->jumlah,
                    'keterangan' => $requestData['keterangan'],
                    'status' => 'baru'
                ];
                $tanggalJatuhTempo = Carbon::parse($requestData['tanggal_jatuh_tempo']);
                $tanggalTagihan = Carbon::parse($requestData['tanggal_tagihan']);
                $bulanTagihan = $tanggalTagihan->format('m');
                $tahunTagihan = $tanggalTagihan->format('Y');
                $cekTagihan = Model::where('siswa_id', $itemSiswa->id)
                    ->where('nama_biaya', $itemBiaya->nama)
                    ->whereMonth('tanggal_tagihan', $bulanTagihan)
                    ->whereYear('tanggal_tagihan', $tahunTagihan)
                    ->first();
                if($cekTagihan == null){
                    Model::create($dataTagihan);
                }
                //print foreach(perulangan)
                // print_r($dataTagihan);
                // echo '<br>';
            }
        }
        flash("Data berhasil disimpan")->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Model $tagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $tagihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagihanRequest  $request
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagihanRequest $request, Model $tagihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $tagihan)
    {
        //
    }
}

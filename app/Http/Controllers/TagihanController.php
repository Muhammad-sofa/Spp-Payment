<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Biaya;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use App\Models\Tagihan as Model;
use App\Http\Requests\StoreTagihanRequest;
use App\Http\Requests\UpdateTagihanRequest;

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
            $models = Model::latest()
                ->whereMonth('tanggal_tagihan', $request->bulan)
                ->whereYear('tanggal_tagihan', $request->tahun)
                ->paginate(50);
        }else{
            $models = Model::latest()->paginate(50);
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
        foreach ($siswa as $itemSiswa) {
            $biaya = Biaya::whereIn('id', $biayaIdArray)->get();
                unset($requestData['biaya_id']);
                $requestData['siswa_id'] = $itemSiswa->id;
                $requestData['status'] = 'baru';
                $tanggalTagihan = Carbon::parse($requestData['tanggal_tagihan']);
                $bulanTagihan = $tanggalTagihan->format('m');
                $tahunTagihan = $tanggalTagihan->format('Y');
                $cekTagihan = Model::where('siswa_id', $itemSiswa->id)
                    ->whereMonth('tanggal_tagihan', $bulanTagihan)
                    ->whereYear('tanggal_tagihan', $tahunTagihan)
                    ->first();
                if($cekTagihan == null){
                    $tagihan = Model::create($requestData);
                    foreach ($biaya as $itemBiaya) {
                        $detail = TagihanDetail::create([
                            'tagihan_id' => $tagihan->id,
                            'nama_biaya' => $itemBiaya->nama,
                            'jumlah_biaya' => $itemBiaya->jumlah,
                        ]);
                    }
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
    public function show(Request $request, $id)
    {
        $tagihan = Model::findOrFail($id);
        $data['tagihan'] = $tagihan;
        $data['siswa'] = $tagihan->siswa;
        $data['periode'] = Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat('F Y');
        $data['model'] = new Pembayaran();
        return view('operator.' . $this->viewShow, $data);
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

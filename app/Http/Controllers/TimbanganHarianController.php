<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksiModel;
use App\Models\KategoriBarang;
use App\Models\KeuanganModel;
use App\Models\TransaksiModel;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

use function Psy\debug;

class TimbanganHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = TransaksiModel::select(DB::raw('users.name, transaksi.*, count(transaksi_detail.id_barang) total_barang, sum(transaksi_detail.harga_awal * transaksi_detail.quantity) harga_jual, sum(transaksi_detail.laba) laba'))->join('users','transaksi.id_user', 'users.id')->leftjoin('transaksi_detail','transaksi.id_transaksi','transaksi_detail.id_transaksi')->groupBy('transaksi.id_transaksi')->get(); 
        
        if(Auth::user()->id_role == 2){
            $users = User::where("id_bsu", Auth::user()->id)->pluck("id"); 
            
            $data = TransaksiModel::select(DB::raw('users.name, transaksi.*, count(transaksi_detail.id_barang) total_barang, sum(transaksi_detail.harga_awal * transaksi_detail.quantity) harga_jual, sum(transaksi_detail.laba) laba'))->join('users','transaksi.id_user', 'users.id')->leftjoin('transaksi_detail','transaksi.id_transaksi','transaksi_detail.id_transaksi')->whereIn("transaksi.id_user", $users)->groupBy('transaksi.id_transaksi')->get(); 
        }

        if(request()->ajax()){
            return DataTables::of($data)
            ->addColumn('action', function($data) {
                $action = '';
                $action .= '<a href="'. url('timbangan-harian/destroy', $data->id_transaksi) .'" class="btn btn-sm btn-danger">Hapus</a>';
                $action .= ' <a href="'. url('timbangan-harian/detail', $data->id_transaksi) .'" class="btn btn-sm btn-success">Detail</a>';
                // ini akses untuk BSU aja
                if(Auth::user()->id_role == 2){
                    $action .= ' <a href="'. route('timbangan-harian.edit', $data->id_transaksi) .'" class="btn btn-sm btn-warning">Edit</a>';

                }
                return $action;
            })->make();
        }
        return view('backend.timbangan-harian.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('id_bsu', Auth::user()->id)->get();
        return view('backend.timbangan-harian.create', compact('user'));
        //
    }
  
    public function rekap_timbangan()
    {
        if(Auth::user()->id_role == 2){
            $user = User::where('id_bsu', Auth::user()->id)->get();
        }elseif(Auth::user()->id_role == 1){
            $user = User::where('id_role', 2)->get();
         }else{
            $user = User::where('id_role', 3)->get();
        }
        return view('backend.rekap-tabungan.index', compact('user'));
        //
    }
  
    public function bank_sampah()
    {
        $user = User::where('id_bsu', Auth::user()->id)->get();
        $kategori_barang = KategoriBarang::all();
        return view('backend.bank-sampah.index', compact('user','kategori_barang'));
        //
    }

    public function filter_rekap_timbangan(Request $request){ 
        $us = User::where('id',$request->id_nasabah)->first();
        $tanggal_awal = date('Y-m-d', strtotime(str_replace("/","-",$request->tanggal_awal)));
        $tanggal_akhir = date('Y-m-d', strtotime(str_replace("/","-",$request->tanggal_akhir)));
        
        if($us->id_role == 2){
            
            $nasabah = User::where('id_bsu',$us->id)->pluck('id');
       
            if(Auth::user()->id_role == 1 || Auth::user()->id_role == 10 ){
                $data_masuk = TransaksiModel::leftjoin('transaksi_detail','transaksi_detail.id_transaksi','transaksi.id_transaksi')
                ->whereIn('transaksi.id_user', $nasabah)
                ->whereDate('transaksi.tanggal' ,">=", $tanggal_awal )
                ->whereDate('transaksi.tanggal' ,"<=", $tanggal_akhir )
                ->select(DB::RAW("transaksi.tanggal, sum(transaksi_detail.harga_awal * transaksi_detail.quantity) amount, sum(transaksi_detail.laba) laba "))
                ->groupBy('transaksi.tanggal')
                ->get();
                
            }else{
                
                $data_masuk = TransaksiModel::leftjoin('transaksi_detail','transaksi_detail.id_transaksi','transaksi.id_transaksi')
                ->whereIn('transaksi.id_user', $nasabah)
                ->whereDate('transaksi.tanggal' ,">=", $tanggal_awal )
                ->whereDate('transaksi.tanggal' ,"<=", $tanggal_akhir )
                ->select(DB::RAW("transaksi.tanggal, sum(transaksi_detail.harga * transaksi_detail.quantity) amount, sum(transaksi_detail.laba) laba "))
                ->groupBy('transaksi.tanggal')
                ->get();
            }
    
            $data_out = KeuanganModel::whereIn('id_user', $nasabah)
            ->whereDate('keuangan.tanggal' ,">=", $tanggal_awal )
            ->whereDate('keuangan.tanggal' ,"<=", $tanggal_akhir )
            ->select(DB::RAW("keuangan.tanggal, sum(keuangan.amount) amount"))
            ->groupBy('keuangan.tanggal')
            ->get();
        }else{
            if(Auth::user()->id_role == 1  || Auth::user()->id_role == 10 ){
                $data_masuk = TransaksiModel::leftjoin('transaksi_detail','transaksi_detail.id_transaksi','transaksi.id_transaksi')
                ->where('transaksi.id_user', $request->id_nasabah)
                ->whereDate('transaksi.tanggal' ,">=", $tanggal_awal )
                ->whereDate('transaksi.tanggal' ,"<=", $tanggal_akhir )
                ->select(DB::RAW("transaksi.tanggal, sum(transaksi_detail.harga_awal * transaksi_detail.quantity) amount, sum(transaksi_detail.laba) laba "))
                ->groupBy('transaksi.tanggal')
                ->get();
                
            }else{
                
                $data_masuk = TransaksiModel::leftjoin('transaksi_detail','transaksi_detail.id_transaksi','transaksi.id_transaksi')
                ->where('transaksi.id_user', $request->id_nasabah)
                ->whereDate('transaksi.tanggal' ,">=", $tanggal_awal )
                ->whereDate('transaksi.tanggal' ,"<=", $tanggal_akhir )
                ->select(DB::RAW("transaksi.tanggal, sum(transaksi_detail.harga * transaksi_detail.quantity) amount, sum(transaksi_detail.laba) laba "))
                ->groupBy('transaksi.tanggal')
                ->get();
            }
            // printJSON($data_masuk);
    
            $data_out = KeuanganModel::where('id_user', $request->id_nasabah)
            ->whereDate('keuangan.tanggal' ,">=", $tanggal_awal )
            ->whereDate('keuangan.tanggal' ,"<=", $tanggal_akhir )
            ->select(DB::RAW("keuangan.tanggal, sum(keuangan.amount) amount"))
            ->groupBy('keuangan.tanggal')
            ->get();

        } 
        $data = array();
        foreach ($data_masuk as $key => $value) {
            $data[] = $value; 
        }
        foreach ($data_out as $key => $value) {
            $value->amount = $value->amount * -1;
            $data[] = $value; 
        } 
        if(Auth::user()->id_role == 2){
            $user = User::where('id_bsu', Auth::user()->id)->get();
        }elseif(Auth::user()->id_role == 1){
            $user = User::where('id_role', 2)->get();
         }else{
            $user = User::where('id_role', 3)->get();
        }
        return view('backend.rekap-tabungan.index', compact('user','data','us')); 
    }

    public function filter_rekap_bank_sampah(Request $request){ 
        
        $tanggal_awal = date('Y-m-d', strtotime(str_replace("/","-",$request->tanggal_awal)));
        $tanggal_akhir = date('Y-m-d', strtotime(str_replace("/","-",$request->tanggal_akhir)));
        $data_masuk = TransaksiModel::leftjoin('transaksi_detail','transaksi_detail.id_transaksi','transaksi.id_transaksi')
        ->where('transaksi.id_user', $request->id_nasabah)
        ->whereDate('transaksi.tanggal' ,">=", $tanggal_awal )
        ->whereDate('transaksi.tanggal' ,"<=", $tanggal_akhir )
        ->select(DB::RAW("transaksi.tanggal, sum(transaksi_detail.harga) amount"))
        ->groupBy('transaksi.tanggal')
        ->get();
       
        $detail = TransaksiModel::leftjoin('transaksi_detail','transaksi_detail.id_transaksi','transaksi.id_transaksi')
        ->leftjoin('barang','barang.id_barang','transaksi_detail.id_barang') 
        ->where('transaksi.id_user', $request->id_nasabah)
        ->whereDate('transaksi.tanggal' ,">=", $tanggal_awal )
        ->whereDate('transaksi.tanggal' ,"<=", $tanggal_akhir )
        ->select(DB::RAW("transaksi.tanggal, transaksi_detail.quantity, transaksi_detail.harga, barang.id_kategori_barang"))
        ->groupBy('transaksi.tanggal','barang.id_kategori_barang')
        ->get();

        // printJSON($detail);

       if(Auth::user()->id_role == 2){
           $user = User::where('id_bsu', Auth::user()->id)->get();
       }elseif(Auth::user()->id_role == 1){
           $user = User::where('id_role', 2)->get();
        }else{
           $user = User::where('id_role', 3)->get();
       }
      
        $kategori_barang = KategoriBarang::all();
        return view('backend.bank-sampah.index', compact('user','data_masuk','kategori_barang', 'detail')); 
    }

    public function tabungan(Request $request){ 
        
        $tanggal_awal = date('Y-m-d', strtotime(str_replace("/","-",$request->tanggal_awal)));
        $tanggal_akhir = date('Y-m-d', strtotime(str_replace("/","-",$request->tanggal_akhir)));
        $data_masuk = TransaksiModel::leftjoin('transaksi_detail','transaksi_detail.id_transaksi','transaksi.id_transaksi')
        ->where('transaksi.id_user', $request->id_nasabah)
        ->whereDate('transaksi.tanggal' ,">=", $tanggal_awal )
        ->whereDate('transaksi.tanggal' ,"<=", $tanggal_akhir )
        ->select(DB::RAW("transaksi.tanggal, sum(transaksi_detail.harga) amount"))
        ->groupBy('transaksi.tanggal')
        ->get();
       
        $detail = TransaksiModel::leftjoin('transaksi_detail','transaksi_detail.id_transaksi','transaksi.id_transaksi')
        ->leftjoin('barang','barang.id_barang','transaksi_detail.id_barang') 
        ->where('transaksi.id_user', $request->id_nasabah)
        ->whereDate('transaksi.tanggal' ,">=", $tanggal_awal )
        ->whereDate('transaksi.tanggal' ,"<=", $tanggal_akhir )
        ->select(DB::RAW("transaksi.tanggal, transaksi_detail.quantity, transaksi_detail.harga, barang.id_kategori_barang"))
        ->groupBy('transaksi.tanggal','barang.id_kategori_barang')
        ->get();

        
        if(Auth::user()->id_role == 2){
            $user = User::where('id_bsu', Auth::user()->id)->get();
        }elseif(Auth::user()->id_role == 1){
            $user = User::where('id_role', 2)->get();
        }else{
            $user = User::where('id_role', 3)->get();
        }
        
        $kategori_barang = KategoriBarang::all();
        return view('backend.tabungan.index', compact('user','data_masuk','kategori_barang', 'detail')); 
    }
    
    public function filterTabungan(Request $request)
    {
        $tanggal_awal = date('Y-m-01', strtotime($request->tahun."-".$request->bulan. "-01"));
        $tanggal_akhir = date('Y-m-t', strtotime($request->tahun."-".$request->bulan. "-01"));
        $bulan = $request->bulan;
        $nasabah = User::where('id_bsu', Auth::user()->id)->pluck('id');
        if(!empty($request->id_bsu)){
            $nasabah = User::where('id_bsu', $request->id_bsu)->pluck('id');
        }
        if(Auth::user()->id_role == 2){
            $data_masuk = TransaksiModel::leftjoin('transaksi_detail','transaksi_detail.id_transaksi','transaksi.id_transaksi')
            ->leftjoin('users as tg','tg.id','transaksi.id_user')
            ->whereIn('transaksi.id_user', $nasabah)
            ->whereDate('transaksi.tanggal' ,">=", $tanggal_awal )
            ->whereDate('transaksi.tanggal' ,"<=", $tanggal_akhir )
            ->select(DB::RAW("tg.name, transaksi.tanggal, sum(transaksi_detail.harga * transaksi_detail.quantity) amount, sum(transaksi_detail.laba) laba "))
            ->groupBy('transaksi.tanggal','transaksi.id_user')
            ->get();
            
        }else{
            $data_masuk = TransaksiModel::leftjoin('transaksi_detail','transaksi_detail.id_transaksi','transaksi.id_transaksi')
            ->leftjoin('users as tg','tg.id','transaksi.id_user')
            ->whereIn('transaksi.id_user', $nasabah)
            ->whereDate('transaksi.tanggal' ,">=", $tanggal_awal )
            ->whereDate('transaksi.tanggal' ,"<=", $tanggal_akhir )
            ->select(DB::RAW("tg.name, transaksi.tanggal, sum(transaksi_detail.harga_awal * transaksi_detail.quantity) amount, sum(transaksi_detail.laba) laba "))
            ->groupBy('transaksi.tanggal','transaksi.id_user')
            ->get();

        }

        if(Auth::user()->id_role == 2){
            $user = User::where('id_bsu', Auth::user()->id)->get();
        }elseif(Auth::user()->id_role == 1){
            $user = User::where('id_role', 2)->get();
        }else{
            $user = User::where('id_role', 3)->get();
        }
        return view('backend.tabungan.index', compact('user','data_masuk','bulan' ));  
        # code...
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $tanggal_transaksi = str_replace("/","-", $request->tanggal_transaksi); 

        $id = null;
        if(isset($request->id_transaksi)){
            $id = $request->id_transaksi;
            TransaksiModel::where('id_transaksi', $id)->update([
                'tanggal' => date('Y-m-d', strtotime($tanggal_transaksi)),
                'id_user'   => $request->id_nasabah,
                'nomor_transaksi' => str_pad((TransaksiModel::count()+1), "4", "0", STR_PAD_LEFT) ."-BSI-".date('Ymd'),
            ]);
        }else{
            TransaksiModel::insert([
                'tanggal' => date('Y-m-d', strtotime($tanggal_transaksi)),
                'id_user'   => $request->id_nasabah,
                'nomor_transaksi' => str_pad((TransaksiModel::count()+1), "4", "0", STR_PAD_LEFT) ."-BSI-".date('Ymd'),
            ]);
            $id = DB::getPdo()->lastInsertId();

        }

        DetailTransaksiModel::where('id_transaksi', $id)->delete();

        // dd($request->all());
        foreach ($request->id_barang as $key => $value) {
            DetailTransaksiModel::insert([
                'id_transaksi'  => $id,
                'id_barang' => $request->id_barang[$key],
                'quantity' => str_replace(",", "", $request->quantity[$key]),
                'harga' => str_replace(",", "", $request->harga[$key]),
                'harga_awal' => str_replace(",", "", $request->harga_awal[$key]),
                'laba' => str_replace(",", "", $request->laba[$key]),
                'laba_total' => str_replace(",", "", $request->laba_total[$key]),
            ]);
        }
        return redirect('timbangan-harian');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id_role', 3)->get();
        $data = TransaksiModel::join('users','transaksi.id_user', 'users.id')->where('transaksi.id_transaksi', $id)->first(); 
        $detail = DetailTransaksiModel::join('barang', 'barang.id_barang', 'transaksi_detail.id_barang')->select(DB::RAW('barang.nama_barang, transaksi_detail.*'))->where('transaksi_detail.id_transaksi' , $id)->get();
        return view('backend.timbangan-harian.detail', compact('user','data','detail'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id_role', 3)->get();
        $data = TransaksiModel::join('users','transaksi.id_user', 'users.id')->where('transaksi.id_transaksi', $id)->first(); 
        $detail = DetailTransaksiModel::join('barang', 'barang.id_barang', 'transaksi_detail.id_barang')->select(DB::RAW('barang.nama_barang, transaksi_detail.*'))->where('transaksi_detail.id_transaksi' , $id)->get();
        // printJSON($detail);
        return view('backend.timbangan-harian.create', compact('user','data','detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TransaksiModel::where('id_transaksi',$id)->delete();
        DetailTransaksiModel::where('id_transaksi',$id)->delete();

        return redirect('timbangan-harian');
    }
}

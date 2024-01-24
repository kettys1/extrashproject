<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksiModel;
use App\Models\KeuanganModel;
use App\Models\TransaksiModel;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

use function Psy\debug;

class RealisasiTabunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = KeuanganModel::join('users','keuangan.id_user', 'users.id'); 

        if(Auth::user()->id_role == 2){
            $data->where('users.id_bsu', Auth::user()->id)->get();
        }
        if(Auth::user()->id_role == 3){
            $data->where('users.id', Auth::user()->id )->get();
        }
      
        $data->get(); 

        if(request()->ajax()){
            return DataTables::of($data)
            ->addColumn('action', function($data) {
                $action = '';
                $action .= '<a href="'. url('realisasi-tabungan/destroy', $data->id_keuangan) .'" class="btn btn-sm btn-danger">Hapus</a>';
                // $action .= ' <button type="button" class="btn btn-sm btn-success btn-detail">Detail</button>';
                $action .= ' <button type="button" class="btn btn-sm btn-warning btn-edit">Edit</button>';
                if($data->is_approve == null){
                    $action .= ' <button type="button" class="btn btn-sm btn-success btn-approve">Setujui</button>';
                }else{
                    $action .= ' <button type="button" class="btn btn-sm btn-success btn-unapprove">Batal Setujui</button>';
                }
                return $action;
            })
        
            ->addColumn('tabungan', function($data){
                $data = User::join('transaksi', 'transaksi.id_user','users.id')
                ->leftjoin('transaksi_detail','transaksi_detail.id_transaksi','transaksi.id_transaksi')
                ->leftjoin(DB::raw('(SELECT sum(amount) as amount , id_user from keuangan group by id_user) nilai_ambil '), function($join) {
                    $join->on('users.id', '=', 'nilai_ambil.id_user');
                })
                ->where('users.id', $data->id_user)
                ->select(DB::RAW('users.*, IFNULL(sum(transaksi_detail.harga * transaksi_detail.quantity) - IFNULL(nilai_ambil.amount,0),0) as tabungan'))
                ->groupBy('users.id')
                ->first();

                return isset($data->tabungan) ? $data->tabungan : 0;
            })
            ->make(true);
        }
        return view('backend.realisasi-tabungan.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::all();
        return view('backend.timbangan-harian.create', compact('user'));
        //
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
        if(isset($request->id_keuangan)){
            $id = $request->id_keuangan;
            KeuanganModel::where('id_keuangan', $id)->update([
                'tanggal' => date('Y-m-d', strtotime($tanggal_transaksi)),
                'id_user'   => $request->id_user,
                'amount'   => $request->amount,
                'nomor_keuangan' => str_pad((KeuanganModel::count()+1), "4", "0", STR_PAD_LEFT) ."-BSI-OUT-".date('Ymd'),
            ]);
        }else{
            KeuanganModel::insert([
                'tanggal' => date('Y-m-d', strtotime($tanggal_transaksi)),
                'id_user'   => $request->id_user,
                'amount'   => $request->amount,
                'nomor_keuangan' => str_pad((KeuanganModel::count()+1), "4", "0", STR_PAD_LEFT) ."-BSI-OUT-".date('Ymd'),
            ]); 

        }
 
        return redirect('realisasi-tabungan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::all();
        $data = TransaksiModel::join('users','transaksi.id_user', 'users.id')->where('transaksi.id_transaksi', $id)->first(); 
        $detail = DetailTransaksiModel::join('barang', 'barang.id_barang', 'transaksi_detail.id_barang')->where('transaksi_detail.id_transaksi' , $id)->get();
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
        $user = User::all();
        $data = TransaksiModel::join('users','transaksi.id_user', 'users.id')->where('transaksi.id_transaksi', $id)->first(); 
        $detail = DetailTransaksiModel::join('barang', 'barang.id_barang', 'transaksi_detail.id_barang')->where('transaksi_detail.id_transaksi' , $id)->get();
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
    
    public function updatePenarikan(Request $request, $id)
    {
        KeuanganModel::where('id_keuangan', $id)->update([
            'is_approve' => $request->status
        ]);

        return 200;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        KeuanganModel::where('id_keuangan',$id)->delete(); 

        return redirect('realisasi-tabungan');
    }
}

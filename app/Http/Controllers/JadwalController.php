<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksiModel;
use App\Models\JadwalModel;
use App\Models\KeuanganModel;
use App\Models\TransaksiModel;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;

use function Psy\debug;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = JadwalModel::all(); 
        $bsu = User::where('id_role',2)->get();
        if(request()->ajax()){
            return DataTables::of($data)
            ->addColumn('action', function($data) {
                $action = '';
                $action .= '<a href="'. url('jadwal/destroy', $data->id) .'" class="btn btn-sm btn-danger">Hapus</a>';
                // $action .= ' <button type="button" class="btn btn-sm btn-success btn-detail">Detail</button>';
                $action .= ' <button type="button" class="btn btn-sm btn-warning btn-edit">Edit</button>';
                return $action;
            })
            ->addColumn('bsu', function($data) {
                $d  = DB::table('jadwal_bsu')->join('users','users.id','jadwal_bsu.id_bsu')->where('id_jadwal', $data->id)->get();
                return json_decode($d); 
            })
            ->addColumn('bsu_id', function($data) {
                $d  = DB::table('jadwal_bsu')->join('users','users.id','jadwal_bsu.id_bsu')->where('id_jadwal', $data->id)->pluck('jadwal_bsu.id_bsu');
                return json_decode($d); 
            })
            ->make();
        }
        return view('backend.jadwal.index', compact('bsu'));
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
 
        $tanggal_awal = str_replace("/","-", $request->tanggal_awal); 
        $tanggal_akhir = str_replace("/","-", $request->tanggal_akhir); 
        $id = null;
        if(isset($request->id_jadwal)){
            $id = $request->id_jadwal;
            JadwalModel::where('id', $id)->update([
                'tanggal_awal' => date('Y-m-d', strtotime($tanggal_awal)),
                'tanggal_akhir' => date('Y-m-d', strtotime($tanggal_akhir)),
                'alamat'   => $request->alamat,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        }else{
            JadwalModel::insert([
                'tanggal_awal' => date('Y-m-d', strtotime($tanggal_awal)),
                'tanggal_akhir' => date('Y-m-d', strtotime($tanggal_akhir)),
                'alamat'   => $request->alamat,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]); 
            $id = DB::getPdo()->lastInsertId();
            
        }
        DB::table('jadwal_bsu')->where('id_jadwal', $id)->delete();
        foreach ($request->id_bsu as $key) {
            DB::table('jadwal_bsu')->insert([
                'id_bsu'   => $key,
                'id_jadwal' => $id
            ]);
        }
 
        return redirect('jadwal');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        JadwalModel::where('id',$id)->delete(); 

        return redirect('jadwal');
    }
}

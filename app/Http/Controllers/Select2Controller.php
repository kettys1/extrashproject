<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class Select2Controller extends Controller
{
    public function barangSelect2(Request $request){
        $data = Barang::all();
        if(!empty($request->term)){
            $data = Barang::where('nama_barang','LIKE', "%{$request->term}%")->get();
        }
        return response()->json($data);
    }

    public function select2kategori(Request $request){
        $data = KategoriBarang::all();
        if(!empty($request->term)){
            $data = KategoriBarang::where('nama_kategori_barang','LIKE', "%${$request->term}%")->get();
        }
        return response()->json($data);
    }

    public function select2nasabah(Request $request){
        $data = User::join('transaksi', 'transaksi.id_user','users.id')
        ->leftjoin('transaksi_detail','transaksi_detail.id_transaksi','transaksi.id_transaksi')
        ->leftjoin(DB::raw('(SELECT sum(amount) as amount , id_user from keuangan group by id_user) nilai_ambil '), function($join) {
            $join->on('users.id', '=', 'nilai_ambil.id_user');
        })
        ->select(DB::RAW('users.*, IFNULL(sum(transaksi_detail.harga * transaksi_detail.quantity) - IFNULL(nilai_ambil.amount,0),0) as tabungan'));
        if(!empty($request->term)){
            $data = $data->where('users.name','LIKE',"%${$request->term}%");
        }
        if(Auth::user()->id_role == 3){
            $data = $data->where('users.id',Auth::user()->id);
        }
        if(Auth::user()->id_role == 2){
            $data = $data->where('users.id_bsu',Auth::user()->id);
        }
        $data->groupBy('users.id');
        $data->get();
        $data = $data->get();
        return response()->json($data);
    }
}

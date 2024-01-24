<?php

use App\Models\Barang;
use App\Models\JadwalModel;
use App\Models\KegiatanModel;
use App\Models\PengurusModel;
use App\Models\User;

function removeDecimal($val){
    return str_replace(".00", "", $val);
}

function printJSON($v){
    header('Access-Control-Allow-Origin: *');
    header("Content-type: application/json");
    echo json_encode($v, JSON_PRETTY_PRINT);
    exit;
}

function dashboardElement(){
    $k = new stdClass();
    $k->nasabah = User::where('id_role',3)->count();
    $da = DB::table("transaksi_detail")->join("barang","barang.id_barang", "transaksi_detail.id_barang")->get(); 
    $k->plastik = collect($da)->where('id_kategori_barang',8)->count();
    $k->kertas = collect($da)->where('id_kategori_barang',7)->count();
    $k->lain_lain = collect($da)->where('id_kategori_barang',12)->count();
    $k->kegiatan = KegiatanModel::limit(3)->orderBy('id',"DESC")->get();
    $k->pengurus = PengurusModel::all();
    return $k;
}

function groupBarang(){
    return   Barang::select(DB::raw('count(id_barang) as total_barang, kategori_barang.nama_kategori_barang'))->leftjoin('kategori_barang','kategori_barang.id_kategori_barang', 'barang.id_kategori_barang')->groupBy('kategori_barang.id_kategori_barang')->whereNotNull('kategori_barang.id_kategori_barang')->get();
}


function jadwalGLobal(){
    $data = collect( JadwalModel::orderBy('created_at','ASC')->get())->map(function($row){
        $row->bsu_unit  = DB::table('jadwal_bsu')->join('users','users.id','jadwal_bsu.id_bsu')->where('id_jadwal', $row->id)->get();
        return $row;
    });

    return $data;
}

function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return  $bulan[ (int)$pecahkan[1] ];
}
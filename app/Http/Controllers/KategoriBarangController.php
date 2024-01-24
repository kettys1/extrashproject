<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;

class KategoriBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = KategoriBarang::all();
        // printJSON($data);
        if(request()->ajax()){
            return DataTables::of($data)
            ->addColumn('action', function($data) {
                $action = '';
                $action .= '<a href="'. url('kategori-barang/destroy', $data->id_kategori_barang) .'" class="btn btn-sm btn-danger">Hapus</a>';
                // $action .= ' <a href="'. url('kategori-barang/detail', $data->id_kategori_barang) .'" class="btn btn-sm btn-success">Detail</a>';
                $action .= ' <button type="button" class="btn btn-sm btn-warning btn-edit">Edit</button>';
                return $action;
            })->make();
        }
        return view('backend.kategori-barang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        if(isset($request->id_kategori_barang)) {
            KategoriBarang::where('id_kategori_barang', $request->id_kategori_barang)->update([
                'nama_kategori_barang' => $request->nama_kategori_barang
            ]);
        } else {
            KategoriBarang::insert([
                'nama_kategori_barang' => $request->nama_kategori_barang
            ]);
        }
        return redirect('kategori-barang');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        KategoriBarang::where('id_kategori_barang',$id)->delete();

        return redirect('kategori-barang');
    }
}

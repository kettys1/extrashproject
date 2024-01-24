<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Barang::select(DB::raw('barang.*, kategori_barang.nama_kategori_barang'))->leftjoin('kategori_barang','kategori_barang.id_kategori_barang', 'barang.id_kategori_barang')->get();
        if(request()->ajax()){
            return DataTables::of($data)
            ->addColumn('action', function($data) {
                $action = '';
                $action .= '<a href="'. url('barang/destroy', $data->id_barang) .'" class="btn btn-sm btn-danger">Hapus</a>';
                // $action .= ' <a href="'. url('barang/detail', $data->id_barang) .'" class="btn btn-sm btn-success">Detail</a>';
                $action .= ' <button type="button" class="btn btn-sm btn-warning btn-edit">Edit</button>';
                return $action;
            })->make();
        }
        return view('backend.barang.index');
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
        if(isset($request->id_barang)) {
            Barang::where('id_barang', $request->id_barang)->update([
                'id_kategori_barang' => $request->id_kategori_barang,
                'nama_barang' => $request->nama_barang,
                'harga' => $request->harga,
            ]);
        } else {
            Barang::insert([
                'id_kategori_barang' => $request->id_kategori_barang,
                'nama_barang' => $request->nama_barang,
                'harga' => $request->harga,
            ]);
        }

        return redirect('barang');
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
        Barang::where('id_barang',$id)->delete();

        return redirect('barang');
    }
}

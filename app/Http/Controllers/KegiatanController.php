<?php

namespace App\Http\Controllers;

use App\Models\KegiatanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = KegiatanModel::all();
        if(request()->ajax()){
            return DataTables::of($data)
            ->addColumn('action', function($data) {
                $action = '';
                $action .= '<a href="'. url('kegiatan-bsi/destroy', $data->id) .'" class="btn btn-sm btn-danger">Hapus</a>';
                // $action .= ' <a href="'. url('barang/detail', $data->id) .'" class="btn btn-sm btn-success">Detail</a>';
                $action .= ' <button type="button" class="btn btn-sm btn-warning btn-edit">Edit</button>';
                return $action;
            })->make();
        }
        return view('backend.kegiatan.index');
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
        $filenameSimpan = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSvf9wn1WvKWCp2eCV0atTl56ONzL6TyTPh702UMXqeHag2ZUG0YPch6-XWd2o4S_dK1J4&usqp=CAU';
        if(isset($request->id_kegiatan)){
            $data =   KegiatanModel::where('id', $request->id_kegiatan)->first();
            $filenameSimpan = $data->foto;
            if($request->hasFile('foto')){
                $file           = $request->file('foto'); 
                $nama_file      = date('YmdHis').str_replace(' ','', $file->getClientOriginalName()); 
                $file->move('kegiatan',$nama_file);
                $filenameSimpan = $nama_file;
            } 
            KegiatanModel::where('id', $request->id_kegiatan)->update([
                'keterangan' => $request->keterangan,
                'judul' => $request->judul,
                'foto'  => $filenameSimpan
            ]);
        }else{
            if($request->hasFile('foto')){
                $file           = $request->file('foto'); 
                $nama_file      = date('YmdHis').str_replace(' ','', $file->getClientOriginalName()); 
                $file->move('kegiatan',$nama_file);
                $filenameSimpan = $nama_file;
            } 
            $kegiatan = new KegiatanModel();
            $kegiatan->keterangan = $request->keterangan;
            $kegiatan->judul = $request->judul;
            $kegiatan->foto = $filenameSimpan;
            $kegiatan->save();

        }

        return redirect()->route('kegiatan-bsi.index');
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
        KegiatanModel::where('id', $id)->delete();
        return redirect()->route('kegiatan-bsi.index');
    }
}

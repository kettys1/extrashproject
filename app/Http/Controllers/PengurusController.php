<?php

namespace App\Http\Controllers;

use App\Models\PengurusModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PengurusModel::all();
        if(request()->ajax()){
            return DataTables::of($data)
            ->addColumn('action', function($data) {
                $action = '';
                $action .= '<a href="'. url('pengurus-bsi/destroy', $data->id_pengurus) .'" class="btn btn-sm btn-danger">Hapus</a>';
                // $action .= ' <a href="'. url('barang/detail', $data->id) .'" class="btn btn-sm btn-success">Detail</a>';
                $action .= ' <button type="button" class="btn btn-sm btn-warning btn-edit">Edit</button>';
                return $action;
            })->make();
        }
        return view('backend.pengurus.index');
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
        if(isset($request->id_pengurus)){
            $data =   PengurusModel::where('id_pengurus', $request->id_pengurus)->first();
            $filenameSimpan = $data->foto_pengurus;
            if($request->hasFile('foto_pengurus')){
                $file           = $request->file('foto_pengurus'); 
                $nama_file      = date('YmdHis').str_replace(' ','', $file->getClientOriginalName()); 
                $file->move('pengurus',$nama_file);
                $filenameSimpan = $nama_file;
            } 
            PengurusModel::where('id_pengurus', $request->id_pengurus)->update([
                'nama_pengurus' => $request->nama_pengurus,
                'quote' => $request->quote,
                'foto_pengurus'  => $filenameSimpan
            ]);
        }else{
            if($request->hasFile('foto_pengurus')){
                $file           = $request->file('foto_pengurus'); 
                $nama_file      = date('YmdHis').str_replace(' ','', $file->getClientOriginalName()); 
                $file->move('pengurus',$nama_file);
                $filenameSimpan = $nama_file;
            } 
            $pengurus = new PengurusModel();
            $pengurus->nama_pengurus = $request->nama_pengurus;
            $pengurus->quote = $request->quote;
            $pengurus->foto_pengurus = $filenameSimpan;
            $pengurus->save();

        }

        return redirect()->route('pengurus-bsi.index');
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
        PengurusModel::where('id_pengurus', $id)->delete();
        return redirect()->route('pengurus-bsi.index');
    }
}

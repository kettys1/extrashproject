<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::join('role', 'role.id_role', 'users.id_role')->leftjoin('users as tg','users.id_bsu','tg.id')->select(DB::RAW('users.*, role.nama_role, tg.name as nama_bsu'));

        if(Auth::user()->id_role == 2){
            $data->where('users.id_bsu', Auth::user()->id)->get();
        }
        
        
        $data->get();
        // printJSON($data);
        if(request()->ajax()){
            return DataTables::of($data)
            ->addColumn('action', function($data) {
                $action = '';
                $action .= '<a href="'. url('destroy_user', $data->id) .'" class="btn btn-sm btn-danger">Hapus</a>';
                // $action .= ' <a href="'. url('user/detail', $data->id_kategori_barang) .'" class="btn btn-sm btn-success">Detail</a>';
                $action .= ' <button type="button" class="btn btn-sm btn-warning btn-edit">Edit</button>';
                return $action;
            })->make();
        }
// printJSON(Auth::user()->id_role);
        if(Auth::user()->id_role == 1){ 
            $role = DB::table('role')->where('id_role', 2)->get();
        }
        if(Auth::user()->id_role == 10){ 
            $role = DB::table('role')->where('id_role', 1)->get();
        }
        if(Auth::user()->id_role == 2){
            $role = DB::table('role')->where('id_role', 3)->get();
        }
        return view('backend.user.index', compact('role'));
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
        $role = $request->id_role;
        $id_bsu = null;
        
        if(Auth::user()->id_role == 2){
            $role = 3;
            $id_bsu = Auth::user()->id;
        }
        if(isset($request->id_user)) {
            $oldData = User::where('id', $request->id_user)->first();
            User::where('id', $request->id_user)->update([
                'name' => $request->name,
                'email' => $request->email,
                'id_role' => $role,
                'id_bsu' => $id_bsu,
                'alamat' => $request->alamat,
                'password' => empty($request->password) ? $oldData->password : Hash::make($request->password)
            ]);
        } else {
            User::insert([
                'name' => $request->name,
                'email' => $request->email,
                'id_role' => $role,
                'id_bsu' => $id_bsu,
                'alamat' => $request->alamat,
                'password' => Hash::make($request->password)
            ]);
        }
        return redirect('users');
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
        User::where('id',$id)->delete();

        return redirect('users');
    }
}

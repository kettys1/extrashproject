<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('home');
        }else{
            return view('login');
        }
    }

    public function actionlogin(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        if (Auth::Attempt($data)) {
            return redirect('admin');
        }else{
            Session::flash('error', 'Email atau Password Salah');
            return redirect('/');
        }
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect('/');
    }

    function actionregister(Request $request){
        DB::beginTransaction();

        try {
           
            User::insert([
                'name' => $request->name,
                'email' => $request->email,
                'id_role' => 3,
                'id_bsu' => $request->id_bsu,
                'alamat' => $request->alamat,
                'password' => Hash::make($request->password)
            ]);
    
            $id_user = DB::getPdo()->lastInsertId();
            $da = User::where('id', $id_user)->first();
            DB::commit();
    
            $data = [
                'email' => $da->email,
                'password' => $request->password,
            ];
            if (Auth::Attempt($data)) {
                return redirect('admin');
            }else{
                Session::flash('error', 'Email atau Password Salah');
                return redirect('/');
            } 
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            printJSON($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        request()->session()->invalidate();
 
        request()->session()->regenerateToken();
 
        return redirect('/login');
    }
}
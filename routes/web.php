<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\RealisasiTabunganController;
use App\Http\Controllers\TimbanganHarianController;
use App\Http\Controllers\Select2Controller;
use App\Http\Controllers\UserController;
use App\Models\Barang;
use App\Models\JadwalModel;
use App\Models\KategoriBarang;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend/home');
});

Route::get('admin', function () {
    return view('backend/dashboard');
});
Route::get('tentang-kami', function () {
    return view('frontend/tentang-kami');
}); 
Route::get('kontak-kami', function () {
    return view('frontend/kontak-kami');
});  
Route::get('register-nasabah', function () {
    $bsu = User::where('id_role',2)->get();
    return view('register', compact('bsu'));
});  
Route::get('jadwal-timbang', function () {
    return view('frontend/jadwal');
});  
Route::get('kategori-sampah', function () {
    $kategoriBarang = KategoriBarang::all();
    $barang = Barang::select(DB::raw('barang.*, kategori_barang.nama_kategori_barang'))->leftjoin('kategori_barang','kategori_barang.id_kategori_barang', 'barang.id_kategori_barang')->get();
    // printJSON($barang);
    return view('frontend/kategori-sampah', compact('kategoriBarang','barang'));
});  
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
Route::post('actionregister', [LoginController::class, 'actionregister'])->name('actionregister');


Route::middleware(['hasRole'])->group(function() {
    Route::resource('kegiatan-bsi', KegiatanController::class); 
    Route::get('kegiatan-bsi/destroy/{id}', [KegiatanController::class ,'destroy']);
    
    Route::resource('pengurus-bsi', PengurusController::class); 
    Route::get('pengurus-bsi/destroy/{id}', [PengurusController::class ,'destroy']);
    
    Route::resource('timbangan-harian', TimbanganHarianController::class); 
    Route::get('timbangan-harian/destroy/{id}', [TimbanganHarianController::class ,'destroy']);
    Route::get('timbangan-harian/detail/{id}', [TimbanganHarianController::class ,'show']);
    Route::get('barangSelect2', [Select2Controller::class ,'barangSelect2'])->name('barangSelect2');
    Route::get('select2nasabah', [Select2Controller::class ,'select2nasabah'])->name('select2nasabah');
    
    Route::resource('realisasi-tabungan', RealisasiTabunganController::class); 
    Route::get('realisasi-tabungan/destroy/{id}', [RealisasiTabunganController::class ,'destroy']);
    Route::get('rekap-timbangan', [TimbanganHarianController::class ,'rekap_timbangan'])->name('rekap-timbangan');
    Route::post('filter-rekap-timbangan', [TimbanganHarianController::class ,'filter_rekap_timbangan'])->name('filter-rekap-timbangan');
    Route::get('bank-sampah', [TimbanganHarianController::class ,'bank_sampah'])->name('bank-sampah');
    Route::post('filter-rekap-bank-sampah', [TimbanganHarianController::class ,'filter_rekap_bank_sampah'])->name('filter-rekap-bank-sampah');
    
    Route::resource('kategori-barang', KategoriBarangController::class); 
    Route::get('kategori-barang/destroy/{id}', [KategoriBarangController::class ,'destroy']);
    
    Route::resource('barang', BarangController::class); 
    Route::get('barang/destroy/{id}', [BarangController::class ,'destroy']);
    Route::get('select2kategori', [Select2Controller::class ,'select2kategori'])->name('select2kategori');
    
    Route::resource('jadwal', JadwalController::class); 
    Route::get('jadwal/destroy/{id}', [JadwalController::class ,'destroy']);
    
    Route::resource('users', UserController::class); 
    Route::post('store_user', [UserController::class ,'store'])->name('store_user');
    Route::get('destroy_user/{id}', [UserController::class ,'destroy']);
    
    Route::resource('penarikan', PenarikanController::class); 
    Route::get('updatePenarikan/{id}', [RealisasiTabunganController::class, 'updatePenarikan']); 
    
    Route::get('tabungan', [TimbanganHarianController::class ,'tabungan'])->name('tabungan');
    Route::post('filterTabungan', [TimbanganHarianController::class ,'filterTabungan'])->name('filterTabungan');
});
Route::post('/logout', [LoginController::class, 'logout']);
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\FakturController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\MidtransController;
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




// Route::get('/', function () {
    //     return view('welcome');
    // });
    
    Route::get('/', function () {return view('landing');
        })->name('landing');
    
    
    Route::get('/login', function(){
        return view('login');
    })->name('login');

    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
    
    Route::middleware('auth')->group(function () {
        // Route::resource('pengguna', PenggunaController::class);


    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });
    
    
    
    

Route::prefix('obat')->group(function () {
    Route::get('/', [ObatController::class, 'index'])->name('obat.index');
    Route::get('/create', [ObatController::class, 'create'])->name('obat.create');
    Route::post('/', [ObatController::class, 'store'])->name('obat.store');
    Route::get('/{obat}/show', [ObatController::class, 'show'])->name('obat.show');
    Route::get('/{obat}/edit', [ObatController::class, 'edit'])->name('obat.edit');
    Route::put('/{obat}', [ObatController::class, 'update'])->name('obat.update');
    Route::delete('/{obat}', [ObatController::class, 'destroy'])->name('obat.destroy');
});

Route::prefix('pengguna')->group(function () {
    Route::get('/', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/create', [PenggunaController::class, 'create'])->name('pengguna.create');
    Route::post('/', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/{pengguna}/edit', [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::put('/{pengguna}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/{pengguna}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
});



Route::prefix('faktur')->group(function () {
    Route::get('/', [FakturController::class, 'index'])->name('faktur.index');
    Route::get('/create', [FakturController::class, 'create'])->name('faktur.create');
    Route::post('/', [FakturController::class, 'store'])->name('faktur.store');
    Route::get('/{faktur}/show', [FakturController::class, 'show'])->name('faktur.show');
    Route::get('/{faktur}/edit', [FakturController::class, 'edit'])->name('faktur.edit');
    Route::put('/{faktur}', [FakturController::class, 'update'])->name('faktur.update');
    Route::delete('/{faktur}', [FakturController::class, 'destroy'])->name('faktur.destroy');
});


// Route::get('/', function () {
//     return redirect()->route('distributors.index');
// });

// Route::resource('distributors', DistributorController::class);

Route::prefix('distributors')->group(function () {
    Route::get('/', [DistributorController::class, 'index'])->name('distributors.index');
    Route::get('/create', [DistributorController::class, 'create'])->name('distributors.create');
    Route::post('/', [DistributorController::class, 'store'])->name('distributors.store');
    Route::get('/{distributor}/edit', [DistributorController::class, 'edit'])->name('distributors.edit');
    Route::put('/{distributor}', [DistributorController::class, 'update'])->name('distributors.update');
    Route::delete('/{distributor}', [DistributorController::class, 'destroy'])->name('distributors.destroy');
});



Route::post('/midtrans/create-transaction', [MidtransController::class, 'create']);
Route::get('/test-midtrans', function () {dd(config('midtrans.server_key'));});
Route::get('/faktur/payment/{id}', [FakturController::class, 'payment'])->name('faktur.payment');
Route::post('/midtrans/callback', [FakturController::class, 'callback']);
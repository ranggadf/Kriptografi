<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VigenereController;
use App\Http\Controllers\CaesarController;
use App\Http\Controllers\AESController;
use App\Http\Controllers\RC4Controller;
use App\Http\Controllers\RC4_dekripsiController;
use App\Http\Controllers\AES_dekripsiController;
use App\Http\Controllers\Caesar_dekripsiController;
use App\Http\Controllers\Vigenere_dekripsiController;
use App\Http\Controllers\DekripsiBerlapisController;
use App\Http\Controllers\EnkripsiBerlapisController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Vigenere routes
Route::get('/vigenere', [VigenereController::class, 'index']);
Route::post('/vigenere/encrypt', [VigenereController::class, 'encrypt'])->name('vigenere.encrypt');
// Caesar routes
Route::get('/caesar', [CaesarController::class, 'index'])->name('caesar.index');
Route::post('/caesar/encrypt', [CaesarController::class, 'encrypt'])->name('caesar.encrypt');
// AES routes
Route::get('/aes', [AESController::class, 'index'])->name('aes.index');
Route::post('/aes/encrypt', [AESController::class, 'encrypt'])->name('aes.encrypt');
// RC4 routes   
Route::get('/rc4', [RC4Controller::class, 'index'])->name('rc4.index');
Route::post('/rc4/encrypt', [RC4Controller::class, 'encrypt'])->name('rc4.encrypt');
// Enkripsi routes
Route::get('/enkripsi', function () {
    return view('enkripsi.enkripsi'); // nanti isi halaman enkripsi
});


// Dekripsi routes
Route::get('/dekripsi', function () {
    return view('dekripsi.dekripsi'); // nanti isi halaman enkripsi
});

// Dekripsi RC4
Route::get('/dekripsi/rc4_dekripsi', [RC4_dekripsiController::class, 'indexDecrypt'])->name('rc4.indexDecrypt');
Route::post('/dekripsi/rc4_dekripsi', [RC4_dekripsiController::class, 'decrypt'])->name('rc4.decrypt');

// Dekripsi AES
Route::get('/dekripsi/aes', [AES_dekripsiController::class, 'indexDecrypt']);
Route::post('/dekripsi/aes', [AES_dekripsiController::class, 'decrypt'])->name('aes.decrypt');

// Dekripsi Caesar
Route::get('/dekripsi/caesar', [Caesar_dekripsiController::class, 'index']);
Route::post('/dekripsi/caesar', [Caesar_dekripsiController::class, 'decrypt'])->name('caesar.decrypt');



// === Route Dekripsi Vigenere Auto-Key ===
Route::get('/dekripsi/vigenere', [Vigenere_dekripsiController::class, 'indexDecrypt']);
Route::post('/dekripsi/vigenere', [Vigenere_dekripsiController::class, 'decrypt'])->name('vigenere.decrypt');

// Dekripsi Berlapis

Route::get('/dekripsi/berlapis', [DekripsiBerlapisController::class, 'index'])->name('dekripsi.berlapis');
Route::post('/dekripsi/berlapis', [DekripsiBerlapisController::class, 'decrypt'])->name('dekripsi.berlapis.proses');

//
// Enkripsi Berlapis


Route::get('/enkripsi/berlapis', [EnkripsiBerlapisController::class, 'index'])->name('enkripsi.berlapis');
Route::post('/enkripsi/berlapis', [EnkripsiBerlapisController::class, 'encrypt'])->name('enkripsi.berlapis.proses');

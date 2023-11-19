<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DataCallController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    if(Auth::check()){ 
        return redirect('dashboard') ; 
    }else{
        return Inertia::render('Auth/Login');
    }
}); 

// Route::fallback(function () {
//     return redirect('/');
// });
Route::middleware('auth')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/usuario', [ProfileController::class, 'usuario'])->name('usuario');
    Route::post('/usuarioEliminar', [ProfileController::class, 'eliminaruser'])->name('usuarioEliminar');
    Route::get('/data', [ProfileController::class, 'data'])->name('data');
     
    Route::post('/regdato', [DataController::class, 'regdato'])->name('regdato'); 
    Route::post('/regdatoaxios', [DataController::class, 'regdatoaxios'])->name('regdatoaxios'); 
    Route::post('/starttruncate', [DataController::class, 'starttruncate'])->name('starttruncate'); 
    
    Route::get('/llamada', [DataCallController::class, 'callstart'])->name('llamada'); 
    Route::post('/llamadaid', [DataCallController::class, 'callstartid'])->name('llamadaid'); 

    Route::get('/callstart2', [DataCallController::class, 'callstart2'])->name('callstart2'); 
    Route::post('/regllamada', [DataCallController::class, 'regllamada'])->name('regllamada'); 

    Route::get('/listaLlamadas', [DataController::class, 'listarData'])->name('listaLlamadas'); 
});

require __DIR__.'/auth.php';

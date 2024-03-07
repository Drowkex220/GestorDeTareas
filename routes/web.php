<?php

use App\Http\Controllers\BuscadorController;
use App\Http\Controllers\FormularioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\addTareaController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\cuotaController;
use App\Http\Controllers\detallesController;
use App\Http\Controllers\indexController;
use App\Http\Controllers\listasController;
use App\Http\Controllers\tareasPendController;
use App\Http\Controllers\usuarioController ;

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


Route::controller(loginController::class)->group(function () {
    Route::get("loginForm", "LoginForm")->name('loginForm');
    Route::post("authenticate", "authenticate")->name('authenticate');
    Route::get("logout", "logout")->name('logout');

});


Route::controller(addTareaController::class)->group(function () {
    Route::get("addTareas", "__invoke")->name('addTareas');
    Route::get("modTareas/{id?}", "modTarea")->name('modTareas')->middleware('auth');
    Route::post("saveTareas/{modo?}", "saveTarea")->name('saveTareas');
    Route::get("formDeleteTarea{id?}", "formDeleteTarea")->name("formDeleteTarea")->middleware('auth');
    Route::post("deleteTarea{id?}", "deleteTarea")->name("deleteTarea")->middleware('auth');
    Route::get("resultadoDelete{message?}/{route?}", "resultadoDelete")->name("resultadoDelete")->middleware('auth');
    Route::get("updTareas/{id?}", "updForm")->name('updTareas')->middleware('auth');
    Route::post("saveUpdTareas", "saveUpdateTareas")->name('saveUpdTareas')->middleware('auth');

});


Route::controller(cuotaController::class)->middleware('auth')->group(function () {
    Route::get("addCuota", "cuotaForm")->name('addCuota');
    Route::get("modCuota/{id?}", "modCuota")->name('modCuota');
    Route::post("saveCuota/{modo?}", "saveCuota")->name('saveCuota');
    Route::get("cuotaMensual", "cuotaMensual")->name('cuotaMensual');
    Route::get("formDeleteCuota{id?}", "formDeleteCuota")->name("formDeleteCuota");
    Route::post("deleteCuota{id?}", "deleteCuota")->name("deleteCuota");
    Route::get("getPdf/{id?}", "getPdf")->name("getPdf");


});

Route::controller(usuarioController::class)->group(function () {
    Route::get("modUsuario/{id?}", "modUsuario")->name('modUsuario')->middleware('auth');
    Route::get("addUsuario", "usuarioForm")->name('addUsuario')->middleware('auth');
    Route::post("saveUsuario/{modo?}", "saveUsuario")->name('saveUsuario')->middleware('auth');
    Route::get("formDeleteUsuario{id?}", "formDeleteUsuario")->name("formDeleteUsuario")->middleware('auth');
    Route::post("deleteUsuario{id?}", "deleteUsuario")->name("deleteUsuario")->middleware('auth');


});

Route::controller(clienteController::class)->group(function () {
    Route::get("addCliente", "clienteForm")->name('addCliente')->middleware('auth');
    Route::get("modCliente/{id?}", "modCliente")->name('modCliente')->middleware('auth');
    Route::post("saveCliente/{modo?}", "saveCliente")->name('saveCliente')->middleware('auth');
    Route::get("formDeleteCliente{id?}", "formDeleteCliente")->name("formDeleteCliente")->middleware('auth');
    Route::post("deleteCliente{id?}", "deleteCliente")->name("deleteCliente")->middleware('auth');
    Route::get("authCliente", "authCliente")->name("authCliente");
    Route::post("checkAuthCliente", "checkAuthCliente")->name("checkAuthCliente");


});

Route::controller(listasController::class)->group(function () {

    Route::get("listaTareas", "listaTareas")->name('listaTareas')->middleware('auth');
    Route::get("listaFiltrarTareas", "filtrarTareas")->name('listaFiltrarTareas')->middleware('auth');
    Route::get("listaFiltrarCuotas", "filtrarCuotas")->name('listaFiltrarCuotas')->middleware('auth');
    Route::post("resultadoFiltrado", "resultadoFiltrado")->name("resultadoFiltrado")->middleware('auth');
    Route::post("resultadoFiltradoCuotas", "resultadoFiltradoCuotas")->name("resultadoFiltradoCuotas")->middleware('auth');

    Route::get("listaCuotas", "listaCuotas")->name('listaCuotas')->middleware('auth');
    Route::get("listaUsuarios", "listaUsuarios")->name('listaUsuarios')->middleware('auth');
    Route::get("listaClientes", "listaClientes")->name('listaClientes')->middleware('auth');
});


Route::controller(tareasPendController::class)->group(function () {
    Route::get("tareasPend", "__invoke")->name('tareasPend')->middleware('auth');
});
Route::controller(indexController::class)->group(function () {
    Route::get("", "index")->name('index');
});


Route::controller(detallesController::class)->group(function () {
    Route::get("detallesTarea/{id?}", "detallesTarea")->name('detallesTarea')->middleware('auth');
});









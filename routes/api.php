<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('categorias')->group(function () {
    Route::get('/', [\App\Http\Controllers\CategoriaController::class, 'buscarCategorias']);
    Route::get('/{id}', [\App\Http\Controllers\CategoriaController::class, 'buscarCategoria']);
    Route::post('/', [\App\Http\Controllers\CategoriaController::class, 'cadastrarCategoria']);
    Route::put('/{id}', [\App\Http\Controllers\CategoriaController::class, 'atualizarCategoria']);
    Route::delete('/{id}', [\App\Http\Controllers\CategoriaController::class, 'excluirCategoria']);
});

Route::prefix('produtos')->group(function () {
    Route::get('/', [\App\Http\Controllers\ProdutoController::class, 'buscarProdutos']);
    Route::get('/{id}', [\App\Http\Controllers\ProdutoController::class, 'buscarProduto']);
    Route::post('/', [\App\Http\Controllers\ProdutoController::class, 'cadastrarProduto']);
    Route::put('/{id}', [\App\Http\Controllers\ProdutoController::class, 'atualizarProduto']);
    Route::delete('/{id}', [\App\Http\Controllers\ProdutoController::class, 'excluirProduto']);
});

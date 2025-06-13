<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatController;

Route::prefix('cats')->group(function () {
    Route::get('/', [CatController::class, 'mostrarGatos'])->name('cats.index');
    Route::get('/breeds', [CatController::class, 'listarRacas'])->name('cats.breeds');
    Route::get('/race/{id}', [CatController::class, 'imagensPorRaca'])->name('race.imagens');
    Route::get('/categories', [CatController::class, 'listarCategorias'])->name('cats.categories');
    Route::get('/category/{id}', [CatController::class, 'imagensPorCategoria'])->name('category.imagens');
    Route::post('/favorite', [CatController::class, 'favoritarImagem'])->name('cats.favorite');
    Route::get('/favorites', [CatController::class, 'listarFavoritos'])->name('cats.favorites');
});

Route::get('/', function () {
    return view('welcome');
});

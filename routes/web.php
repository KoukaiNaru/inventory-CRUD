<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', [UserController::class, 'home'])->name('home');

// Действия пользователя
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/username', [UserController::class, 'username'])->name('username');
Route::post('/coins', [UserController::class, 'coins'])->name('coins');
Route::post('/mine', [UserController::class, 'mineGold'])->name('mine');
Route::post('/gather', [UserController::class, 'gather'])->name('gather');

// Торговая лавка (магазин)
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::post('/buy/{id}', [ShopController::class, 'buy'])->name('buy');
});

// Инвентарь, ковка, крафт и продажа
Route::prefix('inventory')->name('inventory.')->group(function () {
    Route::get('/list', [ItemController::class, 'item'])->name('list');
    Route::get('/create', [ItemController::class, 'create'])->name('create');
    Route::post('/', [ItemController::class, 'store'])->name('store');
    Route::post('/craft/{id}', [ItemController::class, 'craft'])->name('craft');
    Route::post('/{id}/sell', [ItemController::class, 'sell'])->name('sell');
    Route::get('/{id}', [ItemController::class, 'show'])->name('show');
    Route::delete('/{id}', [ItemController::class, 'destroy'])->name('destroy');
});

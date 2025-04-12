<?php

use App\Http\Controllers\PurchaseReportController;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Purchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/report/purchase/{id}', [PurchaseReportController::class, 'show']);


// Reports
Route::controller(PurchaseReportController::class)
    ->prefix('report')->group(function () {
        
        Route::get('/purchase/{id}', 'show')->name('report.purchase');
        Route::get('/purchase/{id}/orders', 'orders')->name('report.purchase.orders');

    });
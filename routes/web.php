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

// Reports
Route::get('/report/purchase/{id}', [PurchaseReportController::class, 'show'])
    ->name('report.purchase');
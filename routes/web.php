<?php

use App\Http\Controllers\RecordController;
use App\Models\Record;
use Illuminate\Support\Facades\Route;

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

Route::resource('record', RecordController::class)->only('index');
Route::redirect('/', route('record.index'));

Route::post('record/bulk', [RecordController::class, 'bulkStore'])->name('record.bulk-store');

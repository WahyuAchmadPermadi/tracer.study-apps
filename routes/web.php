<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\ReminderController;
use App\Http\Controllers\Admin\JawabanTracerController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\SummaryController;
use App\Http\Controllers\Admin\ProgramStudiController;

use App\Http\Controllers\Alumni\AuthController as AlumniAuthController;
use App\Http\Controllers\Alumni\DashboardController as AlumniDashboardController;
use App\Http\Controllers\Alumni\ProfileController;
use App\Http\Controllers\Alumni\KuesionerController as AlumniKuesionerController;

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'login']);
    Route::post('/login', [AdminAuthController::class, 'authenticate']);
});

Route::prefix('admin')
    ->middleware('admin')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        Route::get('/logout', [AdminAuthController::class, 'logout']);

        /*
        |--------------------------------------------------------------------------
        | ALUMNI
        |--------------------------------------------------------------------------
        */

        Route::resource('alumni', AlumniController::class);

        Route::resource('program-studi', ProgramStudiController::class)->except('show', 'destroy');
        Route::patch('/program-studi/{programStudi}/toggle', [ProgramStudiController::class, 'toggle'])
            ->name('program-studi.toggle');

        /*
        |--------------------------------------------------------------------------
        | REMINDER
        |--------------------------------------------------------------------------
        */

        Route::get('/reminder', [ReminderController::class, 'index'])
            ->name('reminder.index');

        Route::put('/reminder', [ReminderController::class, 'update'])
            ->name('reminder.update');

        Route::post('/reminder/send-now', [ReminderController::class, 'sendNow'])
            ->name('admin.reminder.send-now');

        Route::delete('/reminder/setting-logs', [ReminderController::class, 'clearSettingLogs'])
            ->name('reminder.setting-logs.clear');

        Route::delete('/reminder/logs', [ReminderController::class, 'clearLogs'])
            ->name('reminder.logs.clear');

        /*
        |--------------------------------------------------------------------------
        | IMPORT
        |--------------------------------------------------------------------------
        */

        Route::get('/import', [ImportController::class, 'index'])
            ->name('admin.import.index');

        Route::post('/import', [ImportController::class, 'import'])
            ->name('admin.import');

        Route::get('/import/template', [ImportController::class, 'downloadTemplate'])
            ->name('admin.import.template');

        /*
        |--------------------------------------------------------------------------
        | JAWABAN TRACER
        |--------------------------------------------------------------------------
        */

        Route::get('/jawaban-tracer', [JawabanTracerController::class, 'index'])
            ->name('admin.jawaban-tracer.index');

        Route::get('/jawaban-tracer/{id}', [JawabanTracerController::class, 'show'])
            ->name('admin.jawaban-tracer.show');

        /*
        |--------------------------------------------------------------------------
        | LAPORAN
        |--------------------------------------------------------------------------
        */

        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index');

        Route::post('/laporan', [LaporanController::class, 'filter'])
            ->name('laporan.filter');

        Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])
            ->name('laporan.export.excel');

        Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])
            ->name('laporan.pdf');

        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        Route::get('/summary', [SummaryController::class, 'index'])
            ->name('summary.index');
    });

/*
|--------------------------------------------------------------------------
| ALUMNI
|--------------------------------------------------------------------------
*/

Route::prefix('alumni')->group(function () {

    // Login
    Route::get('/login', [AlumniAuthController::class, 'showLogin'])
        ->name('alumni.login');

    Route::post('/login', [AlumniAuthController::class, 'login'])
        ->name('alumni.login.process');

    // Route setelah login
    Route::middleware('alumni')->group(function () {

        Route::get('/dashboard', [AlumniDashboardController::class, 'index'])
            ->name('alumni.dashboard');

        Route::get('/profile', [ProfileController::class, 'index'])
            ->name('alumni.profile');

        /*
        |--------------------------------------------------------------------------
        | TRACER STUDY (Wizard 8 Halaman)
        |--------------------------------------------------------------------------
        */

        Route::get('/kuesioner', [AlumniKuesionerController::class, 'halaman1'])
            ->name('kuesioner.halaman1');

        Route::post('/kuesioner', [AlumniKuesionerController::class, 'simpanHalaman1'])
            ->name('kuesioner.halaman1.simpan');

        Route::get('/kuesioner/2', [AlumniKuesionerController::class, 'halaman2'])
            ->name('kuesioner.halaman2');

        Route::post('/kuesioner/2', [AlumniKuesionerController::class, 'simpanHalaman2'])
            ->name('kuesioner.halaman2.simpan');

        Route::get('/kuesioner/3', [AlumniKuesionerController::class, 'halaman3'])
            ->name('kuesioner.halaman3');

        Route::post('/kuesioner/3', [AlumniKuesionerController::class, 'simpanHalaman3'])
            ->name('kuesioner.halaman3.simpan');

        Route::get('/kuesioner/4', [AlumniKuesionerController::class, 'halaman4'])
            ->name('kuesioner.halaman4');

        Route::post('/kuesioner/4', [AlumniKuesionerController::class, 'simpanHalaman4'])
            ->name('kuesioner.halaman4.simpan');

        Route::get('/kuesioner/5', [AlumniKuesionerController::class, 'halaman5'])
            ->name('kuesioner.halaman5');

        Route::post('/kuesioner/5', [AlumniKuesionerController::class, 'simpanHalaman5'])
            ->name('kuesioner.halaman5.simpan');

        Route::get('/kuesioner/6', [AlumniKuesionerController::class, 'halaman6'])
            ->name('kuesioner.halaman6');

        Route::post('/kuesioner/6', [AlumniKuesionerController::class, 'simpanHalaman6'])
            ->name('kuesioner.halaman6.simpan');

        Route::get('/kuesioner/7', [AlumniKuesionerController::class, 'halaman7'])
            ->name('kuesioner.halaman7');

        Route::post('/kuesioner/7', [AlumniKuesionerController::class, 'simpanHalaman7'])
            ->name('kuesioner.halaman7.simpan');

        Route::get('/kuesioner/8', [AlumniKuesionerController::class, 'halaman8'])
            ->name('kuesioner.halaman8');

        Route::post('/kuesioner/submit', [AlumniKuesionerController::class, 'submit'])
            ->name('kuesioner.submit');

        Route::post('/logout', [AlumniAuthController::class, 'logout'])
            ->name('alumni.logout');
    });
});

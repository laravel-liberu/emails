<?php

use Illuminate\Support\Facades\Route;
use LaravelLiberu\Emails\Http\Controllers\Emails\Destroy;
use LaravelLiberu\Emails\Http\Controllers\Emails\Edit;
use LaravelLiberu\Emails\Http\Controllers\Emails\InitTable;
use LaravelLiberu\Emails\Http\Controllers\Emails\Send;
use LaravelLiberu\Emails\Http\Controllers\Emails\Store;
use LaravelLiberu\Emails\Http\Controllers\Emails\TableData;
use LaravelLiberu\Emails\Http\Controllers\Emails\Update;

Route::middleware(['api', 'auth', 'core'])
    ->prefix('api/emails')
    ->as('emails.')
    ->group(function () {
        Route::post('send', Send::class)->name('send');
        Route::post('', Store::class)->name('store');
        Route::get('{email}/edit', Edit::class)->name('edit');
        Route::post('{email}/update', Update::class)->name('update');
        Route::delete('{email}', Destroy::class)->name('destroy');
        Route::get('initTable', InitTable::class)->name('initTable');
        Route::get('tableData', TableData::class)->name('tableData');
    });

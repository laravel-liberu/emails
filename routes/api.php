<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Emails\Http\Controllers\Emails\Send;
use LaravelEnso\Emails\Http\Controllers\Emails\Store;
use LaravelEnso\Emails\Http\Controllers\Emails\Edit;
use LaravelEnso\Emails\Http\Controllers\Emails\Update;
use LaravelEnso\Emails\Http\Controllers\Emails\Destroy;
use LaravelEnso\Emails\Http\Controllers\Emails\InitTable;
use LaravelEnso\Emails\Http\Controllers\Emails\TableData;

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

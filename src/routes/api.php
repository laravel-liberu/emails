<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'core'])
    ->namespace('LaravelEnso\Emails\App\Http\Controllers\Emails')
    ->prefix('api/emails')
    ->as('emails.')
    ->group(function () {
        Route::post('send', 'Send')->name('send');
        Route::post('', 'Store')->name('store');
        Route::get('{email}/edit', 'Edit')->name('edit');
        Route::post('{email}/update', 'Update')->name('update');
        Route::delete('{email}', 'Destroy')->name('destroy');
        Route::get('initTable', 'InitTable')->name('initTable');
        Route::get('tableData', 'TableData')->name('tableData');
    });

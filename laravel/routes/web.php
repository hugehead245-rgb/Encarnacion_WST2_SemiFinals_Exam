<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', function (): RedirectResponse {
    return redirect()->route('tasks.index');
});

Route::resource('tasks', TaskController::class)->except(['show']);
Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggleStatus'])->name('tasks.toggle');

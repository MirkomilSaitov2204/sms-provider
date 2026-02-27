<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome', [
    'canRegister' => false,
])->name('home');

Route::inertia('dashboard', 'Dashboard')->name('dashboard');

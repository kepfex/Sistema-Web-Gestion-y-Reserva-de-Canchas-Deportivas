<?php

use App\Livewire\Admin\CourtType\Index as CourtTypeIndex;
use App\Livewire\Admin\CourtType\Create as CourtTypeCreate;
use App\Livewire\Admin\CourtType\Edit as CourtTypeEdit;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Rutas para Tipo de Canchas
        Route::get('court-types', CourtTypeIndex::class)->name('court-types.index');
        Route::get('court-types/create', CourtTypeCreate::class)->name('court-types.create');
        Route::get('court-types/{courtType}/edit', CourtTypeEdit::class)->name('court-types.edit');

        // Rutas para Canchas deportivas
        
    });

require __DIR__.'/auth.php';

<?php

use App\Livewire\Admin\CourtType\Index as CourtTypeIndex;
use App\Livewire\Admin\CourtType\Create as CourtTypeCreate;
use App\Livewire\Admin\CourtType\Edit as CourtTypeEdit;
use App\Livewire\Admin\Court\Index as CourtIndex;
use App\Livewire\Admin\Court\Create as CourtCreate;
use App\Livewire\Admin\Court\Edit as CourtEdit;
use App\Livewire\Admin\Pricing\Index as PricingIndex;
use App\Livewire\Admin\Pricing\Create as PricingCreate;
use App\Livewire\Admin\Pricing\Edit as PricingEdit;
use App\Livewire\Admin\Schedule\Index as ScheduleIndex;
use App\Livewire\Admin\Schedule\Create as ScheduleCreate;
use App\Livewire\Admin\Schedule\Edit as ScheduleEdit;
use App\Livewire\Admin\Reservation\Index as ReservationIndex;
use App\Livewire\Admin\Reservation\Create as ReservationCreate;
use App\Livewire\Admin\Reservation\Edit as ReservationEdit;
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
        Route::get('courts', CourtIndex::class)->name('courts.index');
        Route::get('courts/create', CourtCreate::class)->name('courts.create');
        Route::get('courts/{court}/edit', CourtEdit::class)->name('courts.edit');

        // Rutas para los Precios
        Route::get('pricings', PricingIndex::class)->name('pricings.index');
        Route::get('pricings/create', PricingCreate::class)->name('pricings.create');
        Route::get('pricings/{pricing}/edit', PricingEdit::class)->name('pricings.edit');

        // Rutas para los Horaios
        Route::get('schedules', ScheduleIndex::class)->name('schedules.index');
        Route::get('schedules/create', ScheduleCreate::class)->name('schedules.create');
        Route::get('schedules/{schedule}/edit', ScheduleEdit::class)->name('schedules.edit');
        
        // Rutas para las Reservaciones
        Route::get('reservations', ReservationIndex::class)->name('reservations.index');
        Route::get('reservations/create', ReservationCreate::class)->name('reservations.create');
        Route::get('reservations/{reservation}/edit', ReservationEdit::class)->name('reservations.edit');
    });

require __DIR__.'/auth.php';

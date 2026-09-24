<?php

use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboardController;
use App\Http\Controllers\Tenant\DashboardController as TenantDashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $user = auth()->user();

        if ($user->belongsToSuperadminPanel()) {
            return redirect()->route('superadmin.dashboard');
        }

        if ($user->belongsToTenantPanel()) {
            return redirect()->route('tenant.dashboard');
        }

        return view('dashboard');
    })->name('dashboard');

    Route::prefix('superadmin')->as('superadmin.')->middleware('role:superadmin|admin|manager')->group(function () {
        Route::get('dashboard', [SuperadminDashboardController::class, 'index'])->name('dashboard');

        Route::livewire('staff', 'pages::superadmin.staff.index')->middleware('permission:staff.read')->name('staff.index');
        Route::livewire('staff/create', 'pages::superadmin.staff.create')->middleware('permission:staff.create')->name('staff.create');
        Route::livewire('staff/{staff}/edit', 'pages::superadmin.staff.edit')->middleware('permission:staff.edit')->name('staff.edit');

        Route::livewire('roles', 'pages::superadmin.roles.index')->middleware('permission:roles.read')->name('roles.index');
        Route::livewire('roles/create', 'pages::superadmin.roles.create')->middleware('permission:roles.create')->name('roles.create');
        Route::livewire('roles/{role}/edit', 'pages::superadmin.roles.edit')->middleware('permission:roles.edit')->name('roles.edit');

        Route::livewire('permissions', 'pages::superadmin.permissions.index')->middleware('permission:permissions.read')->name('permissions.index');
    });

    Route::prefix('tenant')->as('tenant.')->middleware('role:owner')->group(function () {
        Route::get('dashboard', [TenantDashboardController::class, 'index'])->name('dashboard');
    });
});

require __DIR__.'/settings.php';

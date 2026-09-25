<?php

use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboardController;
use App\Livewire\Tenant\Agents;
use App\Livewire\Tenant\Billing;
use App\Livewire\Tenant\Channels;
use App\Livewire\Tenant\Contacts;
use App\Livewire\Tenant\Dashboard as TenantDashboard;
use App\Livewire\Tenant\Flows;
use App\Livewire\Tenant\Inbox;
use App\Livewire\Tenant\Settings;
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
        Route::livewire('dashboard', TenantDashboard::class)->name('dashboard');
        Route::livewire('inbox', Inbox::class)->name('inbox');
        Route::livewire('agents', Agents::class)->name('agents');
        Route::livewire('flows', Flows::class)->name('flows');
        Route::livewire('contacts', Contacts::class)->name('contacts');
        Route::livewire('channels', Channels::class)->name('channels');
        Route::livewire('billing', Billing::class)->name('billing');
        Route::livewire('settings', Settings::class)->name('settings');
    });
});

require __DIR__.'/settings.php';

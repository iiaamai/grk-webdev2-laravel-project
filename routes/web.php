<?php

use App\Enums\UserRole;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterCustomerController;
use App\Http\Controllers\Auth\RegisterDriverController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\PortalHomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);

    Route::get('register/customer', [RegisterCustomerController::class, 'create'])->name('register.customer');
    Route::post('register/customer', [RegisterCustomerController::class, 'store']);

    Route::get('register/driver', [RegisterDriverController::class, 'create'])->name('register.driver');
    Route::post('register/driver', [RegisterDriverController::class, 'store']);
});

Route::middleware('auth')->group(function (): void {
    Route::post('logout', LogoutController::class)->name('logout');

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', EmailVerificationNotificationController::class)
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

Route::middleware(['auth', 'verified', 'not_archived'])->group(function (): void {
    Route::middleware('role:'.UserRole::Customer->value)
        ->prefix('customer')
        ->name('customer.')
        ->group(function (): void {
            Route::get('/', PortalHomeController::class)->name('home');
        });

    Route::middleware('role:'.UserRole::Driver->value)
        ->prefix('driver')
        ->name('driver.')
        ->group(function (): void {
            Route::get('/', PortalHomeController::class)->name('home');
        });

    Route::middleware('role:'.UserRole::Staff->value)
        ->prefix('staff')
        ->name('staff.')
        ->group(function (): void {
            Route::get('/', PortalHomeController::class)->name('home');
        });

    Route::middleware('role:'.UserRole::SystemAdmin->value)
        ->prefix('admin')
        ->name('admin.')
        ->group(function (): void {
            Route::get('/', PortalHomeController::class)->name('home');
            Route::post('users', [UserController::class, 'store'])->name('users.store');
        });
});

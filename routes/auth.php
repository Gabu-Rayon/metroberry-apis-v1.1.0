<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Step 1: Welcome Page
    Route::get('/', [AuthenticatedSessionController::class, 'WelcomePage'])->name('welcome.page');

    // Step 2: Sign-up Options Page
    Route::get('users/sign/up/options', [AuthenticatedSessionController::class, 'signUpOptions'])
        ->name('sign.up.options.page');

    // Step 3 (Optional): Sign-in Page for Users with Account
    Route::get('/users/sign/in', [AuthenticatedSessionController::class, 'usersSignInPage'])->name('users.sign.in.page');

    // Step 4 Auth Check
    Route::post('/users/sign/in/store', [AuthenticatedSessionController::class, 'loginstore'])->name('auth.users.sign.in');


    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    //Log Out
    Route::post('users/logout', [AuthenticatedSessionController::class, 'usersSignOut'])
        ->name('logout');

});
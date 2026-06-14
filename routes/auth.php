<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\VerifyOtpController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register.post');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.post');

    Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
    Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
    Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('facebook.login');
    Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback'])->name('facebook.callback');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::prefix('verify-account')->name('otp.')->group(function () {
    Route::get('/', [VerifyOtpController::class, 'show'])->name('verify');
    Route::post('/', [VerifyOtpController::class, 'verify'])->name('submit');
    Route::post('/resend', [VerifyOtpController::class, 'resend'])->name('resend');
});

Route::prefix('customer/verify-account')->name('customer.otp.')->group(function () {
    Route::get('/', [VerifyOtpController::class, 'show'])->name('verify');
    Route::post('/', [VerifyOtpController::class, 'verify'])->name('submit');
    Route::post('/resend', [VerifyOtpController::class, 'resend'])->name('resend');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard-redirect', [AuthenticatedSessionController::class, 'redirectDashboard'])->name('dashboard.redirect');

    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::post('verify-email', [VerifyEmailController::class, 'verifyOtp'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::put('password-change', [PasswordController::class, 'update'])->name('password.change');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

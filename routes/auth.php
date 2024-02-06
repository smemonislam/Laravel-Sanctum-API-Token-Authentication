<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\EmailSendController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;

Route::post('/register', RegisterController::class)->middleware('guest');
Route::post('/login', LoginController::class)->middleware('guest');
Route::post('/logout', LogoutController::class)->middleware(['auth:sanctum']);
Route::post('/forgot-password', ForgotPasswordController::class)->middleware('guest');
Route::post('/reset-password', ResetPasswordController::class)->name('password.update')->middleware('signed');
Route::post('/email-send', EmailSendController::class)->middleware('guest');
Route::post('/verify-email', VerifyEmailController::class)->name('email.verify')->middleware('signed');
<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::resource('websites', WebsiteController::class)->except(['create', 'edit']);
Route::resource('websites.posts', PostController::class)->except(['create', 'edit']);
Route::resource('websites.subscribers', SubscriberController::class)->only(['index', 'show', 'store']);

Route::middleware('signed')->prefix('websites/{website}/subscribers/{subscriber}')->group(function () {
    Route::get('/confirm', [SubscriberController::class, 'confirm'])->name('confirm-subscription');
    Route::get('/unsubscribe', [SubscriberController::class, 'unsubscribe'])->name('unsubscribe');
});

/*
php artisan make:mail ConfirmSubscription --markdown=emails.confirm_subscription
php artisan make:mail Unsubscribed
*/


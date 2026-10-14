<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameKeyController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/shop', [GameController::class, 'shop'])->name('games.shop');

Route::get('/shop/{gamePlatform}', [GameController::class, 'show'])->name('games.show');

Route::get('/contact', function () {
    return view('contact');
});

Route::middleware('guest')->group(function () {

   Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
   Route::post('/login', [AuthController::class, 'login'])->name('login');

   Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
   Route::post('/register', [AuthController::class, 'register'])->name('register');

   Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
   Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');

   Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
   Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

});


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);
    if(!hash_equals((string)$hash, sha1($user->getEmailForVerification()))){
        abort(403);
    }
    if(!$user->hasVerifiedEmail()){
        $user->markEmailAsVerified();
        $user->active = true;
        $user->save();
    }
    return redirect()->route('login.show')->with('success', 'Email verified successfully. You can now sign in.');
})->middleware('signed')->name('verification.verify');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/2fa', [AuthController::class, 'showTwoFactor'])->name('2fa.show');
Route::post('/2fa', [AuthController::class, 'verifyTwoFactor'])->name('2fa.verify');


Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:customer')->group(function () {
        Route::name('customer.')->group(function () {
            Route::prefix('customer')->group(function () {

                Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');

                Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit.show');
                Route::put('/profile/edit', [ProfileController::class, 'update'])->name('profile.edit');

                Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password.show');
                Route::put('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.change-password');

                Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
                Route::post('/cart/{gamePlatform}', [CartController::class, 'store'])->name('cart.store');
                Route::put('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
                Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

                Route::get('/checkout', [SaleController::class, 'create'])->name('checkout.create');
                Route::post('/checkout', [SaleController::class, 'store'])->name('checkout.store');

                Route::get('/purchases', [SaleController::class, 'index'])->name('purchases.index');
                Route::get('/purchases/{sale}', [SaleController::class, 'show'])->name('purchases.show');
            });
        });
    });

    Route::middleware('role:admin')->group(function () {
        Route::name('admin.')->group(function () {
            Route::prefix('admin')->group(function () {

                Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('dashboard.show');

                Route::get('/users/trashed', [UserController::class, 'trashed'])->name('users.trashed');
                Route::patch('/users/trashed/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
                Route::resource('users', UserController::class);

                Route::get('/games/trashed', [GameController::class, 'trashed'])->name('games.trashed');
                Route::patch('/games/trashed/{id}/restore', [GameController::class, 'restore'])->name('games.restore');
                Route::resource('games', GameController::class)->except('show');

                Route::get('/categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
                Route::patch('/categories/trashed/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
                Route::resource('categories', CategoryController::class)->except('show');

                Route::get('/publishers/trashed', [PublisherController::class, 'trashed'])->name('publishers.trashed');
                Route::patch('/publishers/trashed/{id}/restore', [PublisherController::class, 'restore'])->name('publishers.restore');
                Route::resource('publishers', PublisherController::class)->except('show');

                Route::get('/platforms/trashed', [PlatformController::class, 'trashed'])->name('platforms.trashed');
                Route::patch('/platforms/trashed/{id}/restore', [PlatformController::class, 'restore'])->name('platforms.restore');
                Route::resource('platforms', PlatformController::class)->except('show');

                Route::resource('keys', GameKeyController::class)->except('show');
            });
        });
    });

});




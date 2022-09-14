<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\CustomAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route::get('/', function () {
//     return view('login');
// });

Route::get('dashboard', [CustomAuthController::class, 'dashboard']);
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

Route::get('plans', [PackageController::class, 'plans'])->name('plans');
Route::get('paypal-package/{id}', [PackageController::class, 'paypal'])->name('paypal.package');
Route::get('store-paypal-payment}', [PackageController::class, 'store_payment'])->name('storepaypal_payment');


Route::prefix('Package')->group(function () {
    
Route::get('Package', [PackageController::class, 'index'])->name('Package');
Route::get('Package-create', [PackageController::class, 'create'])->name('Package_create');
Route::post('Package-store', [PackageController::class, 'store'])->name('Package_store');
Route::get('Package-edit/{id}', [PackageController::class, 'edit'])->name('Package_edit');
Route::post('Package-update/{id}', [PackageController::class, 'update'])->name('Package_update');
Route::get('Package-destroy/{id}', [PackageController::class, 'destroy'])->name('Package_destroy');

});

Route::any('{url}', function(){
    return view('errors.404');
})->where('url', '.*');

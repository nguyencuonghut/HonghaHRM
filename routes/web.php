<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminAdminController;
use App\Http\Controllers\AdminDepartmentController;
use App\Http\Controllers\AdminDivisionController;
use App\Http\Controllers\AdminPositionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\UserHomeController;
use App\Http\Controllers\UserLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * Admin routes
 */
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'handleLogin'])->name('admin.handleLogin');
Route::get('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::get('/admin/forgot-password', [AdminLoginController::class, 'showForgotPasswordForm'])->name('admin.forgot.password.get');
Route::post('/admin/forgot-password', [AdminLoginController::class, 'submitForgotPasswordForm'])->name('admin.forgot.password.post');
Route::get('/admin/reset-password/{token}', [AdminLoginController::class, 'showResetPasswordForm'])->name('admin.reset.password.get');
Route::post('/admin/reset-password', [AdminLoginController::class, 'submitResetPasswordForm'])->name('admin.reset.password.post');

Route::name('admin.')->prefix('admin')->group(function() {
    Route::group(['middleware'=>'auth:admin'], function() {
        Route::get('/', [AdminHomeController::class, 'index'])->name('home');

        Route::get('departments/get-division/{department_id}', [AdminDepartmentController::class, 'getDivision'])->name('departments.getDivision');
        Route::get('departments/data', [AdminDepartmentController::class, 'anyData'])->name('departments.data');
        Route::resource('departments', AdminDepartmentController::class);

        Route::get('divisions/data', [AdminDivisionController::class, 'anyData'])->name('divisions.data');
        Route::resource('divisions', AdminDivisionController::class);

        Route::get('positions/data', [AdminPositionController::class, 'anyData'])->name('positions.data');
        Route::resource('positions', AdminPositionController::class);

        Route::get('admins/data', [AdminAdminController::class, 'anyData'])->name('admins.data');
        Route::resource('admins', AdminAdminController::class);

        Route::get('users/gallery', [AdminUserController::class, 'gallery'])->name('users.gallery');
        Route::get('users/data', [AdminUserController::class, 'anyData'])->name('users.data');
        Route::resource('users', AdminUserController::class);
        Route::post('users/import', [AdminUserController::class, 'import'])->name('users.import');
    });
});

/**
 * User routes
 */
Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('user.login');
Route::post('/login', [UserLoginController::class, 'handleLogin'])->name('user.handleLogin');
Route::get('/logout', [UserLoginController::class, 'logout'])->name('user.logout');

Route::group(['middleware'=>'auth:web'], function() {
    Route::get('/', [UserHomeController::class, 'index'])->name('user.home');
});

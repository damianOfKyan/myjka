<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\ContractorsController;
use App\Http\Controllers\CertificatesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

// Contractors

Route::get('/', [ContractorsController::class, 'index'])
    ->name('contractors')
    ->middleware('auth');

Route::get('contractors/create', [ContractorsController::class, 'create'])
    ->name('contractors.create')
    ->middleware('auth');

Route::post('contractors', [ContractorsController::class, 'store'])
    ->name('contractors.store')
    ->middleware('auth');

Route::get('contractors/{contractor}/edit', [ContractorsController::class, 'edit'])
    ->name('contractors.edit')
    ->middleware('auth');

Route::put('contractors/{contractor}', [ContractorsController::class, 'update'])
    ->name('contractors.update')
    ->middleware('auth');

Route::delete('contractors/{contractor}', [ContractorsController::class, 'destroy'])
    ->name('contractors.destroy')
    ->middleware('auth');

Route::put('contractors/{contractor}/restore', [ContractorsController::class, 'restore'])
    ->name('contractors.restore')
    ->middleware('auth');


// Certificates

Route::get('certificates', [CertificatesController::class, 'index'])
    ->name('certificates')
    ->middleware('auth');

Route::get('certificates/create', [CertificatesController::class, 'create'])
    ->name('certificates.create')
    ->middleware('auth');

Route::post('certificates', [CertificatesController::class, 'store'])
    ->name('certificates.store')
    ->middleware('auth');

Route::get('certificates/{certificate}/edit', [CertificatesController::class, 'edit'])
    ->name('certificates.edit')
    ->middleware('auth');

Route::get('certificates/{certificate}/print', [CertificatesController::class, 'print'])
    ->name('certificates.print')
    ->middleware('auth');

Route::put('certificates/{certificate}', [CertificatesController::class, 'update'])
    ->name('certificates.update')
    ->middleware('auth');

Route::delete('certificates/{certificate}', [CertificatesController::class, 'destroy'])
    ->name('certificates.destroy')
    ->middleware('auth');

Route::put('certificates/{certificate}/restore', [CertificatesController::class, 'restore'])
    ->name('certificates.restore')
    ->middleware('auth');


// Contacts

Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('auth');

Route::get('contacts/create', [ContactsController::class, 'create'])
    ->name('contacts.create')
    ->middleware('auth');

Route::post('contacts', [ContactsController::class, 'store'])
    ->name('contacts.store')
    ->middleware('auth');

Route::get('contacts/{contact}/edit', [ContactsController::class, 'edit'])
    ->name('contacts.edit')
    ->middleware('auth');

Route::put('contacts/{contact}', [ContactsController::class, 'update'])
    ->name('contacts.update')
    ->middleware('auth');

Route::delete('contacts/{contact}', [ContactsController::class, 'destroy'])
    ->name('contacts.destroy')
    ->middleware('auth');

Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
    ->name('contacts.restore')
    ->middleware('auth');

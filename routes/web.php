<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\CategoriesWarehouseController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ResponsibleController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\CategoryItemController;
use App\Http\Controllers\MeasurementUnitController;
use App\Http\Controllers\OperationTypeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuditController;
use App\Http\Middleware\ThrottleLogins;
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

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/', function () {
    return redirect('/dashboard');
})->middleware(['auth', 'verified']);


Route::view('/info', 'info')->name('info');

Route::get('/prueba', function () {
    return view('prueba');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware(['auth', 'verified']);

Route::get('/tables', function () {
    return view('tables');
})->name('tables')->middleware(['auth', 'verified']);

Route::get('/wallet', function () {
    return view('wallet');
})->name('wallet')->middleware(['auth', 'verified']);

Route::get('/RTL', function () {
    return view('RTL');
})->name('RTL')->middleware(['auth', 'verified']);

Route::get('/profile', function () {
    return view('account-pages.profile');
})->name('profile')->middleware(['auth', 'verified']);

Route::get('/signin', function () {
    return view('account-pages.signin');
})->name('signin');

Route::get('/signup', function () {
    return view('account-pages.signup');
})->name('signup')->middleware('guest');

Route::get('/sign-up', [RegisterController::class, 'create'])
    ->middleware('guest')
    ->name('sign-up');

Route::post('/sign-up', [RegisterController::class, 'store'])
    ->middleware('guest');

Route::get('/sign-in', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('sign-in');

Route::post('/sign-in', [LoginController::class, 'store'])
    ->middleware(['guest', ThrottleLogins::class]);

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'store'])
    ->middleware('guest');

Route::get('/about', function () {
    return view('about');
})->name('about')->middleware(['auth', 'verified']);

Route::get('/proyectos', function () {
    return view('proyectos');
})->name('proyectos')->middleware(['auth', 'verified']);


Route::middleware(['throttle:login_attempts'])->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
});

// Route::get('/laravel-examples/user-profile', [ProfileController::class, 'index'])->name('users.profile')->middleware(['auth', 'verified']);
// Route::put('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])->name('users.update')->middleware(['auth', 'verified']);
// Route::get('/laravel-examples/users-management', [UserController::class, 'index'])->name('users-management')->middleware(['auth', 'verified']);



Route::get('/profile', [ProfileController::class, 'index'])->name('users.profile')->middleware(['auth', 'verified']);
Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update')->middleware(['auth', 'verified']);



// Usuarios
Route::resource('/info/users', UserController::class)->middleware(['auth', 'verified']);
Route::delete('/info/selected-users', [UserController::class, 'deleteAll'])->name('user.delete')->middleware(['auth', 'verified']);
Route::get('/users/pdf', [UserController::class, 'generatePDF'])->name('users.pdf')->middleware(['auth', 'verified']);
Route::get('/users/export-excel', [UserController::class, 'exportExcel'])->name('users.download-excel')->middleware(['auth', 'verified']);

// Estudiantes
Route::resource('/info/students', StudentController::class)->middleware(['auth', 'verified']);
Route::delete('/info/selected-students', [StudentController::class, 'deleteAll'])->name('student.delete')->middleware(['auth', 'verified']);
Route::get('/students/pdf', [StudentController::class, 'generatePDF'])->name('students.pdf')->middleware(['auth', 'verified']);
Route::get('/students/export-excel', [StudentController::class, 'exportExcel'])->name('students.download-excel')->middleware(['auth', 'verified']);
Route::get('/info/students/{id_stud}/modules', [StudentController::class, 'getModules'])->name('students.getModules');

// Periodos
Route::resource('/info/periods', PeriodController::class)->middleware(['auth', 'verified']);
Route::delete('/info/selected-periods', [PeriodController::class, 'deleteAll'])->name('period.delete')->middleware(['auth', 'verified']);
Route::get('/periods/pdf', [PeriodController::class, 'generatePDF'])->name('periods.pdf')->middleware(['auth', 'verified']);
Route::get('/periods/export-excel', [PeriodController::class, 'exportExcel'])->name('periods.download-excel')->middleware(['auth', 'verified']);

// Categorías de Bodega
Route::resource('/info/categories_warehouse', CategoriesWarehouseController::class)->middleware(['auth', 'verified']);
Route::delete('/info/selected-categories-warehouse', [CategoriesWarehouseController::class, 'deleteAll'])->name('category_warehouse.delete')->middleware(['auth', 'verified']);
Route::get('/categories_warehouse/pdf', [CategoriesWarehouseController::class, 'generatePDF'])->name('categories_warehouse.pdf')->middleware(['auth', 'verified']);
Route::get('/categories_warehouse/export-excel', [CategoriesWarehouseController::class, 'exportExcel'])->name('categories_warehouse.download-excel')->middleware(['auth', 'verified']);

// Bodegas
Route::resource('/info/warehouses', WarehouseController::class)->middleware(['auth', 'verified']);
Route::delete('/info/selected-warehouses', [WarehouseController::class, 'deleteAll'])->name('warehouse.delete')->middleware(['auth', 'verified']);
Route::get('/warehouses/pdf', [WarehouseController::class, 'generatePDF'])->name('warehouses.pdf')->middleware(['auth', 'verified']);
Route::get('/warehouses/export-excel', [WarehouseController::class, 'exportExcel'])->name('warehouses.download-excel')->middleware(['auth', 'verified']);

// Responsables
Route::resource('/info/responsibles', ResponsibleController::class)->middleware(['auth', 'verified']);
Route::delete('/info/selected-responsibles', [ResponsibleController::class, 'deleteAll'])->name('responsible.delete')->middleware(['auth', 'verified']);
Route::get('/responsibles/pdf', [ResponsibleController::class, 'generatePDF'])->name('responsibles.pdf')->middleware(['auth', 'verified']);
Route::get('/responsibles/export-excel', [ResponsibleController::class, 'exportExcel'])->name('responsibles.download-excel')->middleware(['auth', 'verified']);

// Módulos
Route::resource('/info/modules', ModuleController::class)->middleware(['auth', 'verified']);
Route::delete('/info/selected-modules', [ModuleController::class, 'deleteAll'])->name('module.delete')->middleware(['auth', 'verified']);
Route::get('/modules/pdf', [ModuleController::class, 'generatePDF'])->name('modules.pdf')->middleware(['auth', 'verified']);
Route::get('/modules/export-excel', [ModuleController::class, 'exportExcel'])->name('modules.download-excel')->middleware(['auth', 'verified']);
Route::get('/modules/{module}/students', [ModuleController::class, 'getStudents'])->name('modules.getStudents');


// Categorías de Ítems
Route::resource('/info/categories_items', CategoryItemController::class)->middleware(['auth', 'verified']);
Route::delete('/info/selected-categories-items', [CategoryItemController::class, 'deleteAll'])->name('category_item.delete')->middleware(['auth', 'verified']);
Route::get('/categories_items/pdf', [CategoryItemController::class, 'generatePDF'])->name('categories_items.pdf')->middleware(['auth', 'verified']);
Route::get('/categories_items/export-excel', [CategoryItemController::class, 'exportExcel'])->name('categories_items.download-excel')->middleware(['auth', 'verified']);

// Unidades de Medida
Route::resource('/info/measurement_units', MeasurementUnitController::class)->middleware(['auth', 'verified']);
Route::delete('/info/selected-measurement-units', [MeasurementUnitController::class, 'deleteAll'])->name('measurement_unit.delete')->middleware(['auth', 'verified']);
Route::get('/measurement_units/pdf', [MeasurementUnitController::class, 'generatePDF'])->name('measurement_units.pdf')->middleware(['auth', 'verified']);
Route::get('/measurement_units/export-excel', [MeasurementUnitController::class, 'exportExcel'])->name('measurement_units.download-excel')->middleware(['auth', 'verified']);

// Tipos de Operaciones
Route::resource('/info/operations', OperationTypeController::class)->middleware(['auth', 'verified']);
Route::delete('/info/selected-operations', [OperationTypeController::class, 'deleteAll'])->name('operation.delete')->middleware(['auth', 'verified']);
Route::get('/operations/pdf', [OperationTypeController::class, 'generatePDF'])->name('operations.pdf')->middleware(['auth', 'verified']);
Route::get('/operations/export-excel', [OperationTypeController::class, 'exportExcel'])->name('operations.download-excel')->middleware(['auth', 'verified']);

// Proyectos
Route::resource('/info/projects', ProjectController::class)->middleware(['auth', 'verified']);
Route::delete('/info/selected-projects', [ProjectController::class, 'deleteAll'])->name('project.delete')->middleware(['auth', 'verified']);
Route::get('/projects/pdf', [ProjectController::class, 'generatePDF'])->name('projects.pdf')->middleware(['auth', 'verified']);
Route::get('/projects/export-excel', [ProjectController::class, 'exportExcel'])->name('projects.download-excel')->middleware(['auth', 'verified']);

//Auditoria
Route::get('/audits', [AuditController::class, 'index'])->middleware(['auth', 'verified'])->name('audits.index');


//Validacion de Cuenta

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/resend', [EmailVerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');


//Verificar vistas de error
Route::get('/force-error-500', function () {
    abort(500);
});

Route::get('/force-error-503', function () {
    abort(503);
});

Route::get('/force-error-403', function () {
    abort(403);
});

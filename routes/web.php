<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\CategoriesWarehouseController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ResponsibleController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\CategoryItemController;
use App\Http\Controllers\MeasurementUnitController;
use App\Http\Controllers\OperationTypeController;
use App\Http\Controllers\ProjectController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;

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
})->middleware('auth');


Route::view('/info', 'info')->name('info');

Route::get('/prueba', function () {
    return view('prueba');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/tables', function () {
    return view('tables');
})->name('tables')->middleware('auth');

Route::get('/wallet', function () {
    return view('wallet');
})->name('wallet')->middleware('auth');

Route::get('/RTL', function () {
    return view('RTL');
})->name('RTL')->middleware('auth');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');


// Rutas para la autenticación de dos factores
Route::middleware(['auth'])->group(function () {
    Route::post('/user/two-factor-authentication', [ProfileController::class, 'enableTwoFactorAuthentication']);
    Route::post('/user/confirmed-two-factor-authentication', [ProfileController::class, 'confirmTwoFactorAuthentication']);
    Route::delete('/user/two-factor-authentication', [ProfileController::class, 'disableTwoFactorAuthentication']);
    Route::post('/user/two-factor-recovery-codes', [ProfileController::class, 'regenerateRecoveryCodes']);
});


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
    ->middleware('guest');

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
})->name('about');

Route::get('/proyectos', function () {
    return view('proyectos');
})->name('proyectos');


// Route::get('/laravel-examples/user-profile', [ProfileController::class, 'index'])->name('users.profile')->middleware('auth');
// Route::put('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])->name('users.update')->middleware('auth');
// Route::get('/laravel-examples/users-management', [UserController::class, 'index'])->name('users-management')->middleware('auth');



Route::get('/profile', [ProfileController::class, 'index'])->name('users.profile');
Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');



// Usuarios
Route::resource('/info/users', UserController::class)->middleware('auth');
Route::delete('/info/selected-users', [UserController::class, 'deleteAll'])->name('user.delete')->middleware('auth');
Route::get('/users/pdf', [UserController::class, 'generatePDF'])->name('users.pdf')->middleware('auth');
Route::get('/users/export-excel', [UserController::class, 'exportExcel'])->name('users.download-excel')->middleware('auth');

// Estudiantes
Route::resource('/info/students', StudentController::class)->middleware('auth');
Route::delete('/info/selected-students', [StudentController::class, 'deleteAll'])->name('student.delete')->middleware('auth');
Route::get('/students/pdf', [StudentController::class, 'generatePDF'])->name('students.pdf')->middleware('auth');
Route::get('/students/export-excel', [StudentController::class, 'exportExcel'])->name('students.download-excel')->middleware('auth');

// Periodos
Route::resource('/info/periods', PeriodController::class)->middleware('auth');
Route::delete('/info/selected-periods', [PeriodController::class, 'deleteAll'])->name('period.delete')->middleware('auth');
Route::get('/periods/pdf', [PeriodController::class, 'generatePDF'])->name('periods.pdf')->middleware('auth');
Route::get('/periods/export-excel', [PeriodController::class, 'exportExcel'])->name('periods.download-excel')->middleware('auth');

// Categorías de Bodega
Route::resource('/info/categories_warehouse', CategoriesWarehouseController::class)->middleware('auth');
Route::delete('/info/selected-categories-warehouse', [CategoriesWarehouseController::class, 'deleteAll'])->name('category_warehouse.delete')->middleware('auth');
Route::get('/categories_warehouse/pdf', [CategoriesWarehouseController::class, 'generatePDF'])->name('categories_warehouse.pdf')->middleware('auth');
Route::get('/categories_warehouse/export-excel', [CategoriesWarehouseController::class, 'exportExcel'])->name('categories_warehouse.download-excel')->middleware('auth');

// Bodegas
Route::resource('/info/warehouses', WarehouseController::class)->middleware('auth');
Route::delete('/info/selected-warehouses', [WarehouseController::class, 'deleteAll'])->name('warehouse.delete')->middleware('auth');
Route::get('/warehouses/pdf', [WarehouseController::class, 'generatePDF'])->name('warehouses.pdf')->middleware('auth');
Route::get('/warehouses/export-excel', [WarehouseController::class, 'exportExcel'])->name('warehouses.download-excel')->middleware('auth');

// Responsables
Route::resource('/info/responsibles', ResponsibleController::class)->middleware('auth');
Route::delete('/info/selected-responsibles', [ResponsibleController::class, 'deleteAll'])->name('responsible.delete')->middleware('auth');
Route::get('/responsibles/pdf', [ResponsibleController::class, 'generatePDF'])->name('responsibles.pdf')->middleware('auth');
Route::get('/responsibles/export-excel', [ResponsibleController::class, 'exportExcel'])->name('responsibles.download-excel')->middleware('auth');

// Módulos
Route::resource('/info/modules', ModuleController::class)->middleware('auth');
Route::delete('/info/selected-modules', [ModuleController::class, 'deleteAll'])->name('module.delete')->middleware('auth');
Route::get('/modules/pdf', [ModuleController::class, 'generatePDF'])->name('modules.pdf')->middleware('auth');
Route::get('/modules/export-excel', [ModuleController::class, 'exportExcel'])->name('modules.download-excel')->middleware('auth');

// Categorías de Ítems
Route::resource('/info/categories_items', CategoryItemController::class)->middleware('auth');
Route::delete('/info/selected-categories-items', [CategoryItemController::class, 'deleteAll'])->name('category_item.delete')->middleware('auth');
Route::get('/categories_items/pdf', [CategoryItemController::class, 'generatePDF'])->name('categories_items.pdf')->middleware('auth');
Route::get('/categories_items/export-excel', [CategoryItemController::class, 'exportExcel'])->name('categories_items.download-excel')->middleware('auth');

// Unidades de Medida
Route::resource('/info/measurement_units', MeasurementUnitController::class)->middleware('auth');
Route::delete('/info/selected-measurement-units', [MeasurementUnitController::class, 'deleteAll'])->name('measurement_unit.delete')->middleware('auth');
Route::get('/measurement_units/pdf', [MeasurementUnitController::class, 'generatePDF'])->name('measurement_units.pdf')->middleware('auth');
Route::get('/measurement_units/export-excel', [MeasurementUnitController::class, 'exportExcel'])->name('measurement_units.download-excel')->middleware('auth');

// Tipos de Operaciones
Route::resource('/info/operations', OperationTypeController::class)->middleware('auth');
Route::delete('/info/selected-operations', [OperationTypeController::class, 'deleteAll'])->name('operation.delete')->middleware('auth');
Route::get('/operations/pdf', [OperationTypeController::class, 'generatePDF'])->name('operations.pdf')->middleware('auth');
Route::get('/operations/export-excel', [OperationTypeController::class, 'exportExcel'])->name('operations.download-excel')->middleware('auth');

// Proyectos
Route::resource('/info/projects', ProjectController::class)->middleware('auth');
Route::delete('/info/selected-projects', [ProjectController::class, 'deleteAll'])->name('project.delete')->middleware('auth');
Route::get('/projects/pdf', [ProjectController::class, 'generatePDF'])->name('projects.pdf')->middleware('auth');
Route::get('/projects/export-excel', [ProjectController::class, 'exportExcel'])->name('projects.download-excel')->middleware('auth');

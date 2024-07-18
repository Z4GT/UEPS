<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
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
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\KardexController;
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

//ruta por defecto segun el rol
Route::get('/', function () {
    return redirect('/dashboard');
})->middleware(['auth', 'verified', 'role.redirect']);


Route::get('/prueba', function () {
    return view('prueba');
});


Route::get('/tables', function () {
    return view('tables');
})->name('tables')->middleware(['auth', 'verified']);
Route::get('/wallet', function () {
    return view('wallet');
})->name('wallet')->middleware(['auth', 'verified']);

Route::get('/RTL', function () {
    return view('RTL');
})->name('RTL')->middleware(['auth', 'verified']);


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


Route::get('/proyectos', function () {
    return view('proyectos');
})->name('proyectos')->middleware(['auth', 'verified']);


Route::middleware(['throttle:login_attempts'])->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
});

// Route::get('/laravel-examples/user-profile', [ProfileController::class, 'index'])->name('users.profile')->middleware(['auth', 'verified']);
// Route::put('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])->name('users.update')->middleware(['auth', 'verified']);
// Route::get('/laravel-examples/users-management', [UserController::class, 'index'])->name('users-management')->middleware(['auth', 'verified']);






Route::group(['middleware' => ['auth', 'verified', '2fa']], function () {

    //rutas de todos excepto auditor
    Route::group(['middleware' => ['role:administrador|coordinador|rector|jefe de proyecto']], function () {

        // Estudiantes
        Route::resource('/info/students', StudentController::class);
        Route::get('/students/pdf', [StudentController::class, 'generatePDF'])->name('students.pdf');
        Route::get('/students/export-excel', [StudentController::class, 'exportExcel'])->name('students.download-excel');
        Route::get('/info/students/{id_stud}/modules', [StudentController::class, 'getModules'])->name('students.getModules');

        // Periodos
        Route::resource('/info/periods', PeriodController::class);
        Route::get('/periods/pdf', [PeriodController::class, 'generatePDF'])->name('periods.pdf');
        Route::get('/periods/export-excel', [PeriodController::class, 'exportExcel'])->name('periods.download-excel');

        // Categorías de Bodega
        Route::resource('/info/categories_warehouse', CategoriesWarehouseController::class);
        Route::get('/categories_warehouse/pdf', [CategoriesWarehouseController::class, 'generatePDF'])->name('categories_warehouse.pdf');
        Route::get('/categories_warehouse/export-excel', [CategoriesWarehouseController::class, 'exportExcel'])->name('categories_warehouse.download-excel');

        // Bodegas
        Route::resource('/info/warehouses', WarehouseController::class);
        Route::get('/warehouses/pdf', [WarehouseController::class, 'generatePDF'])->name('warehouses.pdf');
        Route::get('/warehouses/export-excel', [WarehouseController::class, 'exportExcel'])->name('warehouses.download-excel');

        // Responsables
        Route::resource('/info/responsibles', ResponsibleController::class);
        Route::get('/responsibles/pdf', [ResponsibleController::class, 'generatePDF'])->name('responsibles.pdf');
        Route::get('/responsibles/export-excel', [ResponsibleController::class, 'exportExcel'])->name('responsibles.download-excel');

        // Módulos
        Route::resource('/info/modules', ModuleController::class);
        Route::get('/modules/pdf', [ModuleController::class, 'generatePDF'])->name('modules.pdf');
        Route::get('/modules/export-excel', [ModuleController::class, 'exportExcel'])->name('modules.download-excel');
        Route::get('/modules/{module}/students', [ModuleController::class, 'getStudents'])->name('modules.getStudents');

        // Categorías de Ítems
        Route::resource('/info/categories_items', CategoryItemController::class);
        Route::get('/categories_items/pdf', [CategoryItemController::class, 'generatePDF'])->name('categories_items.pdf');
        Route::get('/categories_items/export-excel', [CategoryItemController::class, 'exportExcel'])->name('categories_items.download-excel');

        // Unidades de Medida
        Route::resource('/info/measurement_units', MeasurementUnitController::class);
        Route::get('/measurement_units/pdf', [MeasurementUnitController::class, 'generatePDF'])->name('measurement_units.pdf');
        Route::get('/measurement_units/export-excel', [MeasurementUnitController::class, 'exportExcel'])->name('measurement_units.download-excel');

        // Tipos de Operaciones
        Route::resource('/info/operations', OperationTypeController::class);
        Route::get('/operations/pdf', [OperationTypeController::class, 'generatePDF'])->name('operations.pdf');
        Route::get('/operations/export-excel', [OperationTypeController::class, 'exportExcel'])->name('operations.download-excel');


        Route::view('/info', 'info')->name('info');

        // Proyectos
        Route::resource('/info/projects', ProjectController::class);
        Route::get('/projects/pdf', [ProjectController::class, 'generatePDF'])->name('projects.pdf');
        Route::get('/projects/export-excel', [ProjectController::class, 'exportExcel'])->name('projects.download-excel');


        // Tareas
        Route::resource('/info/tasks', TaskController::class);
        Route::get('/tasks/pdf', [TaskController::class, 'generatePDF'])->name('tasks.pdf');
        Route::get('/tasks/export-excel', [TaskController::class, 'exportExcel'])->name('tasks.download-excel');

        // Items
        Route::resource('/info/items', ItemController::class);
        Route::get('/items/pdf', [ItemController::class, 'generatePDF'])->name('items.pdf');
        Route::get('/items/export-excel', [ItemController::class, 'exportExcel'])->name('items.download-excel');
        Route::get('/items/{id}/tags', [ItemController::class, 'getTags']);


        // Kardex
        Route::resource('/info/kardex', KardexController::class);
        Route::get('/kardex/pdf', [KardexController::class, 'generatePDF'])->name('kardex.pdf');
        Route::get('/kardex/export-excel', [KardexController::class, 'exportExcel'])->name('kardex.download-excel');
    });

    // Rutas de administrador
    Route::group(['middleware' => ['role:administrador']], function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


        // Usuarios
        Route::resource('/info/users', UserController::class);
        Route::get('/users/pdf', [UserController::class, 'generatePDF'])->name('users.pdf');
        Route::get('/users/export-excel', [UserController::class, 'exportExcel'])->name('users.download-excel');
        Route::delete('/info/selected-users', [UserController::class, 'deleteAll'])->name('user.delete');
        Route::patch('/info/selected-users/deactivate', [UserController::class, 'deactivateAll'])->name('user.deactivate');

        //Estudiantes
        Route::delete('/info/selected-students', [StudentController::class, 'deleteAll'])->name('student.delete');
        Route::patch('/info/selected-students/deactivate', [StudentController::class, 'deactivateAll'])->name('student.deactivate');

        //Periodos
        Route::delete('/info/selected-periods', [PeriodController::class, 'deleteAll'])->name('period.delete');

        //Categorias de bodega
        Route::delete('/info/selected-categories-warehouse', [CategoriesWarehouseController::class, 'deleteAll'])->name('category_warehouse.delete');

        //Bodegas
        Route::delete('/info/selected-warehouses', [WarehouseController::class, 'deleteAll'])->name('warehouse.delete');

        //Responsable
        Route::delete('/info/selected-responsibles', [ResponsibleController::class, 'deleteAll'])->name('responsible.delete');
        Route::patch('/info/selected-responsibles/deactivate', [ResponsibleController::class, 'deactivateAll'])->name('responsible.deactivate');

        //Modulos
        Route::delete('/info/selected-modules', [ModuleController::class, 'deleteAll'])->name('module.delete');
        Route::patch('/info/selected-modules/deactivate', [ModuleController::class, 'deactivateAll'])->name('module.deactivate');

        //Categorias de items
        Route::delete('/info/selected-categories-items', [CategoryItemController::class, 'deleteAll'])->name('category_item.delete');

        //Unidades de medida
        Route::delete('/info/selected-measurement-units', [MeasurementUnitController::class, 'deleteAll'])->name('measurement_unit.delete');

        //Tipos de operaciones
        Route::delete('/info/selected-operations', [OperationTypeController::class, 'deleteAll'])->name('operation.delete');
    });

    // Rutas de rector, coordinador y jefe de proyecto
    Route::group(['middleware' => ['role:rector|coordinador|jefe de proyecto']], function () {

        //Proyectos 
        Route::get('/projects', [ProjectController::class, 'list'])->name('projects.list');
        Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
        Route::get('projects/export-individual/{id}', [ProjectController::class, 'exportIndividualExcel'])->name('projects.exportIndividualExcel');
    });


    // Rutas de rector
    Route::group(['middleware' => ['role:rector|jefe de proyecto']], function () {

        //Proyectos
        Route::delete('/info/selected-projects', [ProjectController::class, 'deleteAll'])->name('project.delete');

        //Tareas
        Route::delete('/info/selected-tasks', [TaskController::class, 'deleteAll'])->name('task.delete');

        //Items
        Route::delete('/info/selected-items', [ItemController::class, 'deleteAll'])->name('item.delete');

        //Kardex
        Route::delete('/info/selected-kardex', [KardexController::class, 'deleteAll'])->name('kardex.delete');
    });


    // Rutas de auditor
    Route::group(['middleware' => ['role:auditor']], function () {
        Route::get('/audits', [AuditController::class, 'index'])->name('audits.index');
        Route::get('/audits/charts', [AuditController::class, 'charts'])->name('audits.charts');
        Route::get('/audits/pdf', [AuditController::class, 'generatePDF'])->name('audits.pdf');
    });

    // Route::group(['middleware' => ['role:administrador|coordinador']], function () {


    //     Route::view('/info', 'info')->name('info');

    //     // Proyectos
    //     Route::resource('/info/projects', ProjectController::class);
    //     Route::delete('/info/selected-projects', [ProjectController::class, 'deleteAll'])->name('project.delete');
    //     Route::get('/projects/pdf', [ProjectController::class, 'generatePDF'])->name('projects.pdf');
    //     Route::get('/projects/export-excel', [ProjectController::class, 'exportExcel'])->name('projects.download-excel');
    //     Route::get('/projects', [ProjectController::class, 'list'])->name('projects.list');
    //     Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
    //     Route::get('projects/export-individual/{id}', [ProjectController::class, 'exportIndividualExcel'])->name('projects.exportIndividualExcel');


    //     // Tareas
    //     Route::resource('/info/tasks', TaskController::class);
    //     Route::delete('/info/selected-tasks', [TaskController::class, 'deleteAll'])->name('task.delete');
    //     Route::get('/tasks/pdf', [TaskController::class, 'generatePDF'])->name('tasks.pdf');
    //     Route::get('/tasks/export-excel', [TaskController::class, 'exportExcel'])->name('tasks.download-excel');

    //     // Items
    //     Route::resource('/info/items', ItemController::class);
    //     Route::delete('/info/selected-items', [ItemController::class, 'deleteAll'])->name('item.delete');
    //     Route::get('/items/pdf', [ItemController::class, 'generatePDF'])->name('items.pdf');
    //     Route::get('/items/export-excel', [ItemController::class, 'exportExcel'])->name('items.download-excel');
    //     Route::get('/items/{id}/tags', [ItemController::class, 'getTags']);


    //     // Kardex
    //     Route::resource('/info/kardex', KardexController::class);
    //     Route::delete('/info/selected-kardex', [KardexController::class, 'deleteAll'])->name('kardex.delete');
    //     Route::get('/kardex/pdf', [KardexController::class, 'generatePDF'])->name('kardex.pdf');
    //     Route::get('/kardex/export-excel', [KardexController::class, 'exportExcel'])->name('kardex.download-excel');
    // });


    // Rutas compartidas
    Route::get('/info/users/{user}/roles', [UserController::class, 'getUserRoles']);
    Route::get('/profile', [ProfileController::class, 'index'])->name('users.profile')->middleware(['auth']);
    Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/about', function () {
        return view('about');
    })->name('about');
});


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


Route::post('/login-two-factor/{user}', [LoginController::class, 'login2FA'])->name('login.2fa');
Route::get('/login-two-factor/{user}', [LoginController::class, 'show2FAForm'])->name('login.2fa.form');
Route::post('/send-2fa-code/{user}', [LoginController::class, 'send2FACode'])->name('send.2fa.code');

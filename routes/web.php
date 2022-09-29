<?php

use App\Http\Controllers\BrandsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CreateJobController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\EditJobController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModelsController;
use App\Http\Controllers\PrintJobController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

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

/*Route::get('/model', function () {
    return view('model.index_model');
})->middleware('auth');*/

Route::prefix('/')->middleware('auth')->group(function () {

    /*Route::get('/', function () {
    return view('home');
});*/

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('job/create', [CreateJobController::class, 'index'])->name('job_create');
    Route::get('job/edit/{id}', [EditJobController::class, 'index'])->name('job_edit');
    Route::get('job/print={id}', [PrintJobController::class, 'index'])->name('job_print');
    Route::post('job/edit/', [EditJobController::class, 'edit_job'])->name('edit_job');
    Route::get('/settings/users/edit={id}', [UserController::class, 'user_edit'])->name('user_edit');;

    Route::get('job/find_job={id}', [HomeController::class, 'actionFindJob'])->name('FindJob');
    //Status buttons
    Route::get('job/take_job={id}', [HomeController::class, 'actionTakeJob'])->name('TakeJob');
    Route::get('job/suspend_job={id}', [HomeController::class, 'actionSuspend'])->name('SuspendJob');
    Route::get('job/to_work_job={id}', [HomeController::class, 'actionToWork'])->name('ToWorkJob');
    Route::get('job/done_job={id}', [HomeController::class, 'actionDone'])->name('Donejob');
    Route::get('job/close_job={id}', [HomeController::class, 'actionClose'])->name('CloseJob');

    Route::post('find_client', [CreateJobController::class, 'find_client'])->name('find_client');
    Route::post('/create_job-input-fields', [CreateJobController::class, 'add_new_work'])->name('create_job_input_fields');


    //find
    Route::get('find_model/{id}', [CreateJobController::class, 'findModel']);
    Route::post('find_parts/', [EditJobController::class, 'find_parts'])->name('find_parts');
    Route::post('find_brand/', [CreateJobController::class, 'find_brand'])->name('find_brand');
    Route::get('find_vehicle_client/{id}', [CreateJobController::class, 'find_vehicle_client']);
    Route::get('find_vehicle_client_brand_model/{id}', [CreateJobController::class, 'find_vehicle_client_brand_model']);
    Route::post('find_jobs/', [EditJobController::class, 'find_jobs'])->name('find_jobs');

    //Settings
    Route::get('/settings/model', [ModelsController::class, 'index']);
    Route::get('/settings/storage', [StorageController::class, 'index']);
    Route::get('/settings/brand', [BrandsController::class, 'index']);
    Route::get('/settings/vehicle', [VehicleController::class, 'index']);
    Route::get('/settings/clients', [ClientsController::class, 'index']);
    Route::get('/settings/users', [UserController::class, 'index']);
    Route::get('/settings/users/pay{id}', [UserController::class, 'user_pay'])->name('user_pay');
    Route::post('/settings/users/proces', [UserController::class, 'user_edit_proces'])->name('user_edit_proces');
    Route::get('/settings/departments', [DepartmentsController::class, 'index']);
    Route::get('/settings/departments/del{id}', [DepartmentsController::class, 'department_delete'])->name('department_delete');
    Route::post('/settings/departments=new', [DepartmentsController::class, 'department_new'])->name('department_new');
    Route::post('/settings/departments=edit', [DepartmentsController::class, 'department_edit'])->name('department_edit');
    //Route::get('find_info_client/{id}', [CreateJobController::class, 'findinfoclient']);

});


Auth::routes();//(['register' => false]);
Route::get('/test', [TestController::class, 'index']);


/*Route::get('/home', function () {
    return view('home');
});*/
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//TODO Зробити перевірку він номера на існування та запропонувати змінити клієнта
//TODO Зробити ввод числа з крапкою при редагуванні ціни товару чи послуг

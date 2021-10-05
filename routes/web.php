<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group([ 'prefix' => 'admin', 'as'=>'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => 'admin'], function(){
    Route::get('/home', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('index');

    Route::resource('employees', EmployeesController::class);
    Route::resource('departments', DepartmentsController::class);
    Route::resource('tasks', TasksController::class);
});

Route::group(['as'=>'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => 'employee'], function() {
    Route::get('/employees/assigned_tasks', [\App\Http\Controllers\Admin\EmployeesController::class, 'assignedTasks'])->name('employees.assigned_tasks');
});

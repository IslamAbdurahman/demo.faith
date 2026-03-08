<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');

Route::middleware(['auth'])->group(function () {

    Route::get('index', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('home.index');

    ///// Super admin routes /////
    Route::group(['prefix'=>'admin','middleware'=>'super_admin'], function (){

        Route::resources([
            'admin'=>\App\Http\Controllers\AdminController::class]);
        Route::resource('sms', \App\Http\Controllers\SmsController::class);
    });

    ///// Admin routes /////
    Route::group(['prefix'=>'admin','middleware'=>'admin'], function (){

        Route::resource('admin', \App\Http\Controllers\AdminController::class)->only([
            'index', 'show','edit','update'
        ]);

        Route::resource('salaries', \App\Http\Controllers\SalaryController::class)->only([
            'index','store','destroy'
        ]);



        Route::resource('tests', \App\Http\Controllers\TestController::class);
        Route::resource('results', \App\Http\Controllers\ResultController::class);
        Route::resource('sms_services', \App\Http\Controllers\SmsServiceController::class);
        Route::resource('sms', \App\Http\Controllers\SmsController::class)->only([
            'index'
        ]);
        Route::resource('kassas', \App\Http\Controllers\KassaController::class);

    });



    ///// Manager routes /////
    Route::group(['prefix'=>'admin','middleware'=>'manager'], function (){

        Route::resource('admin', \App\Http\Controllers\AdminController::class)->only([
            'show','edit','index'
        ]);

    });

    ///// Teacher routes /////
    Route::group(['prefix'=>'admin','middleware'=>'teacher'], function (){

        Route::resource('admin', \App\Http\Controllers\AdminController::class)->only([
            'index', 'show','edit','update'
        ]);
        Route::resource('teachers', \App\Http\Controllers\TeacherController::class)->only([
            'index', 'show','edit','update','store','destroy'
        ]);
        Route::resource('workers', \App\Http\Controllers\WorkersController::class)->only([
            'index', 'show','edit','update','store','destroy'
        ]);
        Route::resource('attendances', \App\Http\Controllers\AttendanceController::class);
        Route::get('attendances/{s_id}/{g_id}',[\App\Http\Controllers\AttendanceController::class,'show'])->name('attendances.show_two');

        Route::resource('dashboard', \App\Http\Controllers\DashboardController::class)->only([
            'index'
        ]);

    });



    Route::resource('rooms', \App\Http\Controllers\RoomController::class);
    Route::resource('sciences', \App\Http\Controllers\ScienceController::class);
    Route::resource('lids', \App\Http\Controllers\LidController::class);
    Route::resource('lid_students', \App\Http\Controllers\LidStudentController::class);
    Route::resource('students', \App\Http\Controllers\StudentsController::class);
    Route::resource('courses', \App\Http\Controllers\CourseController::class);
    Route::resource('groups', \App\Http\Controllers\GroupController::class);
    Route::resource('student_groups', \App\Http\Controllers\StudentGroupController::class);
    Route::resource('graphics', \App\Http\Controllers\GraphicController::class);
    Route::resource('payments', \App\Http\Controllers\PaymentController::class);

    Route::post('graphic_sms/{graphic_id}', [\App\Http\Controllers\GraphicController::class, 'graphic_sms'])->name('graphic.sms');
    Route::get('graphic_full_sms', [\App\Http\Controllers\GraphicController::class, 'graphic_full_sms'])->name('graphic_full.sms');
    Route::post('group_sms', [\App\Http\Controllers\GroupController::class, 'group_sms'])->name('group.sms');
    Route::post('students_sms', [\App\Http\Controllers\StudentsController::class, 'students_sms'])->name('students.sms');
    Route::get('status_group/{group_id}', [\App\Http\Controllers\GroupController::class, 'status_group'])->name('status.group');
    Route::get('result/export/{test_id}', [\App\Http\Controllers\ResultController::class, 'export'])->name('results.export');
    Route::get('salaries/export', [\App\Http\Controllers\SalaryController::class, 'export'])->name('salaries.export');
    Route::get('payment/export', [\App\Http\Controllers\PaymentController::class, 'export'])->name('payment.export');
    Route::get('graphic/export', [\App\Http\Controllers\GraphicController::class, 'export'])->name('graphics.export');
    Route::get('group/export/{group_id}', [\App\Http\Controllers\GroupController::class, 'export'])->name('group.export');
    Route::get('student/export', [\App\Http\Controllers\StudentsController::class, 'export'])->name('student.export');
    Route::post('student/import', [\App\Http\Controllers\StudentsController::class, 'import'])->name('student.import');
});

Route::get('lang/change', [\App\Http\Controllers\LangController::class, 'change'])->name('changeLang');

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);


//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('form', App\Http\Controllers\FormController::class);

Route::get('payment_check/{id}', [\App\Http\Controllers\PaymentController::class,'payment_check'])->name('payment_check');







//handle requests from payment system
Route::any('/handle/{paysys}', [\App\Http\Controllers\PaymentController::class, 'handle'])->name('payment.handle');

//redirect to payment system or payment form
Route::any('/pay/{paysys}/{key}/{amount}', [\App\Http\Controllers\PaymentController::class, 'redirect'])->name('click');




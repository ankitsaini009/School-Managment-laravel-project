<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\TeacherAuthController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ReleaseCertificatesController;
use App\Http\Controllers\TimeTableController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\SocialiteController;
use App\Models\Banner;
use App\Models\Bannerpojition;


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

Route::get('/clear', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');

    return 'DONE'; //Return anything
});

Route::get('/', function () {
    $banners = Banner::where('bannerpojition', 'Salider Banner')->orderBy('id', 'DESC')->get();
    $Bannerpojition = Banner::where('bannerpojition', 'Home Banner')->orderBy('id', 'DESC')->get();
    return view('home', compact('banners', 'Bannerpojition'));
})->name('home');

Route::post('/adduser', [IndexController::class, 'adduser'])->name('adduser');
Route::get('/registertion', [IndexController::class, 'registertion'])->name('registertion');

Route::get('auth/google', [SocialiteController::class, 'googlepage'])->name('googlepage');
Route::any('auth/google/callback', [SocialiteController::class, 'googlecallback'])->name('googlecallback');

Route::group(['prefix' => 'admin'], function () {

    Route::any('/attendances-add', [IndexController::class, 'attendances_add'])->name('attendances_add');
    Route::get('/banners-image', [BannerController::class, 'index'])->name('banners');
    Route::get('/banneradd', [BannerController::class, 'add'])->name('banneradd');
    Route::post('/storebanner', [BannerController::class, 'store'])->name('storebanner');
    Route::get('/banners-edit/{id}', [BannerController::class, 'edit'])->name('banners.edit');
    Route::post('/banners-update/{id}', [BannerController::class, 'update'])->name('banners.update');
    Route::get('/banners-delete/{id}', [BannerController::class, 'delete'])->name('banners.delete');


    Route::get('/attendances-report', [IndexController::class, 'attendancesreport'])->name('attendances.report');
    Route::get('monthlyreport', [IndexController::class, 'monthlyreport'])->name('monthlyreport');
    Route::get('/school-list', [SchoolController::class, 'index'])->name('schoolopen');
    Route::get('school-add', [SchoolController::class, 'schooladd'])->name('schooladd');
    Route::post('/store-school', [SchoolController::class, 'stoschool'])->name('stoschool');
    Route::get('/school-delete/{id}', [SchoolController::class, 'delete'])->name('delete');
    Route::get('/school-edit/{id}', [SchoolController::class, 'edit'])->name('edit');
    Route::post('/school-updatesch/{id}', [SchoolController::class, 'updatesch'])->name('updatesch');
    Route::get('/', [AdminAuthController::class, 'loginpage'])->name('admin.login.page');
    Route::post('/login', [AdminAuthController::class, 'loginattempt'])->name('login');

    Route::middleware(['IsAdminLogin'])->group(function () {
        Route::get('/delete', [CertificateController::class, 'deleteitem'])->name('delete.item');

        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        Route::get('/settings', [SiteSettingController::class, 'index'])->name('setting.page');
        Route::post('/settings/update', [SiteSettingController::class, 'updatesitesetting'])->name('site.setting.update');
        Route::get('/delete/document', [SiteSettingController::class, 'deletedoc'])->name('delete.document');

        Route::group(['prefix' => 'teachers'], function () {
            Route::get('/', [TeachersController::class, 'index'])->name('teachers.index');
            Route::get('/add', [TeachersController::class, 'addform'])->name('teacher.add.form');
            Route::get('/edit', [TeachersController::class, 'editform'])->name('teacher.edit.form');
            Route::post('/add', [TeachersController::class, 'add'])->name('add.teacher');
            Route::post('/edit', [TeachersController::class, 'edit'])->name('edit.teacher');
            Route::get('/delete/{id}', [TeachersController::class, 'delete'])->name('teacher.delete');
            Route::get('/classcontrol', [TeachersController::class, 'classdata'])->name('class.control');
        });
        Route::group(['prefix' => 'students'], function () {
            Route::get('/', [StudentController::class, 'index'])->name('students.index');
            Route::get('/classsubkects', [StudentController::class, 'classsubjects'])->name('class.subjects');
            Route::get('/add', [StudentController::class, 'addform'])->name('student.add.form');
            Route::get('/edit', [StudentController::class, 'editform'])->name('edit.student.form');
            Route::post('/add', [StudentController::class, 'add'])->name('add.student');
            Route::post('/edit', [StudentController::class, 'edit'])->name('edit.student');
            Route::get('/student-delete/{id}', [StudentController::class, 'delete'])->name('stu.delete');
        });
        Route::group(['prefix' => 'subjects/'], function () {
            Route::get('index', [SubjectController::class, 'index'])->name('subjects.index');
            Route::get('delete/{id}', [SubjectController::class, 'delete'])->name('subject.delete');
            Route::get('data', [SubjectController::class, 'editdata'])->name('subject.data');
            Route::get('subjects', [SubjectController::class, 'teachersubjects'])->name('get.teacher.subject');
            Route::post('edit', [SubjectController::class, 'edit'])->name('subject.edit');
            Route::post('add', [SubjectController::class, 'add'])->name('add.subject');
        });
        Route::group(['prefix' => 'classes'], function () {
            Route::get('/', [ClassController::class, 'index'])->name('classes.index');
            Route::post('add', [ClassController::class, 'add'])->name('add.class');
            Route::post('edit', [ClassController::class, 'edit'])->name('class.edit');
            Route::get('classdata', [ClassController::class, 'editdata'])->name('class.data');
            Route::get('delete/{id}', [ClassController::class, 'delete'])->name('delete.class');
        });
        Route::group(['prefix' => 'sessions'], function () {
            Route::get('/', [ClassController::class, 'index'])->name('sessions.index');
        });

        Route::group(['prefix' => 'time-table'], function () {
            Route::get('/', [TimeTableController::class, 'index'])->name('timtable.index');
            Route::post('/add/period', [TimeTableController::class, 'addperiod'])->name('add.period');
            Route::post('assign/teachers/toperiods', [TimeTableController::class, 'assignteacher'])->name('asign.teacher');
        });
    });
});
Route::group(['prefix' => 'teacher'], function () {
    Route::get('/login', [TeacherAuthController::class, 'loginpage'])->name('teacher.login.page');
    Route::post('/login', [TeacherAuthController::class, 'loginattempt'])->name('teachers.login');
    Route::middleware(['IsTeacherLogin'])->group(function () {
        Route::get('/myacount', [IndexController::class, 'myacount'])->name('myacount');
        Route::post('/proupdate/{id}', [IndexController::class, 'proupdate'])->name('proupdate');
        Route::get('/logout', [IndexController::class, 'logout'])->name('logout');
        Route::get('/changepass', [IndexController::class, 'changepass'])->name('changepass');
        Route::post('/passedit', [IndexController::class, 'passedit'])->name('passedit');
        Route::get('/student', [IndexController::class, 'student'])->name('student');
        Route::get('/studentadd', [IndexController::class, 'studentadd'])->name('studentadd');
        Route::post('/stustor', [IndexController::class, 'stustor'])->name('stustor');
        Route::post('/studentedit/{id}', [IndexController::class, 'studentedit'])->name('studentedit');
        Route::get('/edit/{id}', [IndexController::class, 'edit'])->name('editstu');
        Route::get('/delete/{id}', [IndexController::class, 'delete'])->name('delete');
        Route::any('/attendances-add', [IndexController::class, 'attendances_add'])->name('attendances_add');
        Route::get('/calendar', [IndexController::class, 'calendar'])->name('calendar');
        Route::any('/getajaxcalenderdata', [IndexController::class, 'getajaxcalenderdata'])->name('admin.getajaxcalenderdata');
        Route::get('/dashboard', [TeacherAuthController::class, 'dashboard'])->name('teacher.dashboard');
        Route::get('/classindex', [IndexController::class, 'classindex'])->name('classindex');
        Route::post('/classadd', [IndexController::class, 'classadd'])->name('classadd');
        Route::post('/classedit', [IndexController::class, 'classedit'])->name('classedit');
        Route::get('classdata', [ClassController::class, 'editdata'])->name('class.data');
    });
});

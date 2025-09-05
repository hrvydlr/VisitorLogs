<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuardController;
use App\Http\Controllers\RegisteredIDController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsGuard;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\VisitorTypeController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    if (auth()->check()) {
        $route = (auth()->user()->user_type == 1) ? 'visitor.index' : 'guard.index';
        return redirect()->route($route);
    }
    return redirect()->route('login');
});


Auth::routes();  // Laravel's built-in authentication routes

// Ensure that all routes require authentication
Route::group(['middleware' => ['auth']], function () {

    // Guard Routes
    Route::group(['prefix' => 'guard', 'middleware' => EnsureUserIsGuard::class], function () {
        Route::get('/', [GuardController::class, 'index'])->name('guard.index');
        Route::get('/form', [GuardController::class, 'create'])->name('guard.form');
        Route::post('/setTimeout/{id}', [GuardController::class, 'setTimeout'])->name('guard.setTimeout');
        Route::get('/show/{id}', [GuardController::class, 'show'])->name('guard.show');
        Route::post('/list', [GuardController::class, 'list'])->name('guard.list');
        Route::post('/save', [GuardController::class, 'save'])->name('guard.save');
    });


    // Registered ID Routes
    Route::group(['prefix' => 'registered-id', 'middleware' => EnsureUserIsAdmin::class], function () {
        Route::get('/', [RegisteredIDController::class, 'index'])->name('registered_id.index');
        Route::post('/list', [RegisteredIDController::class, 'list'])->name('registered-id.list');
        Route::post('/save', [RegisteredIDController::class, 'save'])->name('registered-id.save');
        Route::post('/search', [RegisteredIDController::class, 'search'])->name('registered-id.search');
        Route::post('/delete', [RegisteredIDController::class, 'delete'])->name('registered-id.delete');
    });

    // Visitor Routes
    Route::group(['prefix' => 'visitor', 'middleware' => EnsureUserIsAdmin::class], function () {
        Route::get('/', [VisitorController::class, 'index'])->name('visitor.index');
        Route::get('/show/{id}', [VisitorController::class, 'show'])->name('visitor.show');
        Route::get('/form', [VisitorController::class, 'create'])->name('visitor.form');
        Route::post('/save', [VisitorController::class, 'save'])->name('visitor.save');
        Route::get('/form/{id}', [VisitorController::class, 'create'])->name('visitor.edit');
        Route::post('/list', [VisitorController::class, 'list'])->name('visitor.list');
        Route::post('/setTimeout/{id}', [VisitorController::class, 'setTimeout'])->name('visitor.setTimeout');
        Route::post('/search', [VisitorController::class, 'search'])->name('visitor.search');
        Route::post('/delete', [VisitorController::class, 'delete'])->name('visitor.delete');
    });


    Route::get('/get-visitor-type', [VisitorTypeController::class, 'getVisitorType'])->name('visitor.getVisitorType');
    Route::get('/visitors/get-name-by-id', [VisitorController::class, 'getNameById']);
    Route::get('/check-visitor-id/{id_number}/{visitor_type_id}', [VisitorController::class, 'checkVisitorId']);

    // User Routes
    Route::group(['prefix' => 'users', 'middleware' => EnsureUserIsAdmin::class], function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::post('/list', [UserController::class, 'list'])->name('users.list');
        Route::post('/save', [UserController::class, 'save'])->name('users.save');
        Route::post('/search', [UserController::class, 'search'])->name('users.search');
        Route::post('/delete', [UserController::class, 'delete'])->name('users.delete');
    });

    // User Type Routes
    Route::group(['prefix' => 'usertype', 'middleware' => EnsureUserIsAdmin::class], function () {
        Route::get('/', [UserTypeController::class, 'index'])->name('usertype.index');
        Route::post('/list', [UserTypeController::class, 'list'])->name('usertype.list');
        Route::post('/save', [UserTypeController::class, 'save'])->name('usertype.save');
        Route::post('/search', [UserTypeController::class, 'search'])->name('usertype.search');
        Route::post('/delete', [UserTypeController::class, 'delete'])->name('usertype.delete');
    });

    // Visitor Type Routes
    Route::group(['prefix' => 'visitortype', 'middleware' => EnsureUserIsAdmin::class], function () {
        Route::get('/', [VisitorTypeController::class, 'index'])->name('visitortype.index');
        Route::post('/list', [VisitorTypeController::class, 'list'])->name('visitortype.list');
        Route::post('/save', [VisitorTypeController::class, 'save'])->name('visitortype.save');
        Route::post('/search', [VisitorTypeController::class, 'search'])->name('visitortype.search');
        Route::post('/delete', [VisitorTypeController::class, 'delete'])->name('visitortype.delete');
    });

    // Reports Routes
    Route::group(['prefix' => 'reports', 'middleware' => EnsureUserIsAdmin::class], function () {
        Route::get('/', [ReportsController::class, 'index'])->name('reports.index');
        Route::post('/list', [ReportsController::class, 'list'])->name('reports.list');
        Route::get('/show/{id}', [ReportsController::class, 'show'])->name('reports.show');
        Route::post('/search', [ReportsController::class, 'search'])->name('reports.search');
        Route::post('/delete', [ReportsController::class, 'delete'])->name('reports.delete');
    });

    Route::group(['prefix' => 'common'], function () {
        Route::post('/visitor_types', [CommonController::class, 'visitor_types'])->name('common.visitor_types');
    });
});


Route::get('/reports/list', [ReportsController::class, 'list'])->name('reports.list');
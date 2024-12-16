<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarbonFootprintController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReportController;

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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    }
    return redirect()->route('login');
});
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth:sanctum')->group(function () { 

    Route::namespace('Dashboard')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::namespace('User')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/user/create', [UserController::class, 'create']);
        Route::get('/getUsers', [UserController::class, 'getUsers'])->name('getUsers');
        Route::get('/getUserById/{id}', [UserController::class, 'getUserById']);
        Route::put('/saveChanges', [UserController::class, 'updateUser']);
        Route::get('/user/data', [UserController::class, 'getUserData'])->name('user.data');
        Route::get('/getUsersForTeam/{team_id}', [UserController::class, 'getUsersForTeam']);
        Route::get('/instructors', [UserController::class, 'instructor']);
        Route::get('/get-instructors', [UserController::class, 'getInstructor']);
    });

    Route::namespace('CarbonFootprint')->group(function () {
        Route::get('/carbon-footprint', [CarbonFootprintController::class, 'index'])->name('carbon_footprint');
        Route::get('/carbon-footprint/data', [CarbonFootprintController::class, 'getCarbonData']);
        Route::post('/carbon-footprint/create', [CarbonFootprintController::class, 'create']);
        Route::get('/carbon-footprint-all', [CarbonFootprintController::class, 'sdg_index'])->name('carbon_footprint_all');
        Route::get('/carbon-footprint-all/data', [CarbonFootprintController::class, 'getCarbonAllData']);
        Route::get('/carbon-footprint-calculator', [CarbonFootprintController::class, 'calculator_index'])->name('calculator_index');
        Route::get('/openai/calculate', [CarbonFootprintController::class, 'calculate'])->name('calculator_index');
        Route::post('/carbon-create-report', [CarbonFootprintController::class, 'carbonCreateReport']);
    });

    Route::namespace('Announcement')->group(function () {
        Route::get('/announcement', [AnnouncementController::class, 'index'])->name('announcement');
        Route::get('/announcement/data', [AnnouncementController::class, 'getAnnouncementData']);
        Route::post('/announcement/create', [AnnouncementController::class, 'create']);
    });

    Route::namespace('Course')->group(function () {
        Route::get('/sdg-courses', [CourseController::class, 'index'])->name('sdg-project');
        Route::get('/sdg-course/data', [CourseController::class, 'getData']);
        Route::post('/sdg-course/create', [CourseController::class, 'create']);
        Route::get('/sec-sdg-courses', [CourseController::class, 'sec_index'])->name('sec-sdg-courses');
        Route::get('/sec-sdg-course/data', [CourseController::class, 'getSecData']);
        Route::get('/sec-sdg-course-processed/data', [CourseController::class, 'getSecProcessedData']);
        Route::get('/sec-sdg-course-view/{row_id}', [CourseController::class, 'getCourseById']);
        Route::put('/sec-sdg-course-approve/{row_id}/{sdg_approved}', [CourseController::class, 'approve']);
        Route::put('/sec-sdg-course-reject/{row_id}', [CourseController::class, 'reject']);
        Route::get('/sec-sdg-course-view-processed/{row_id}', [CourseController::class, 'getProcessedCourseById']);
    });

    Route::namespace('Project')->group(function () {
        Route::get('/sdg-projects', [ProjectController::class, 'index'])->name('sdg-project');
        Route::get('/sdg-project/data', [ProjectController::class, 'getData']);
        Route::post('/sdg-project/create', [ProjectController::class, 'create']);
        Route::get('/sec-sdg-projects', [ProjectController::class, 'sec_index'])->name('sec-sdg-projects');
        Route::get('/sec-sdg-project/data', [ProjectController::class, 'getSecData']);
        Route::get('/sec-sdg-project-processed/data', [ProjectController::class, 'getSecProcessedData']);
        Route::get('/sec-sdg-project-view/{row_id}', [ProjectController::class, 'getProjectById']);
        Route::put('/sec-sdg-project-approve/{row_id}/{sdg_approved}', [ProjectController::class, 'approve']);
        Route::put('/sec-sdg-project-reject/{row_id}', [ProjectController::class, 'reject']);
        Route::get('/sec-sdg-project-view-processed/{row_id}', [ProjectController::class, 'getProcessedProjectById']);
    });
    
    Route::namespace('Event')->group(function () {
        Route::get('/events', [EventController::class, 'index'])->name('events');
        Route::get('/event/data', [EventController::class, 'getData']);
        Route::post('/event/create', [EventController::class, 'create']);
        Route::get('/event-view/{row_id}', [EventController::class, 'getEventById']);
    });

    Route::namespace('Feedback')->group(function () {
        Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');
        Route::get('/feedback/data', [FeedbackController::class, 'getData']);
        Route::post('/feedback/create', [FeedbackController::class, 'create']);
        Route::get('/feedback-view/{row_id}', [FeedbackController::class, 'getEventById']);
    });

    Route::namespace('Analytic')->group(function () {
        Route::post('/generate-sdg-report', [AnalyticController::class, 'generateSdgReport']);
        Route::get('/sdg', [AnalyticController::class, 'index'])->name('sdg');
    });

    Route::namespace('Report')->group(function () {
        Route::get('/reports', [ReportController::class, 'index']);
        Route::get('/sdg-report/data', [ReportController::class, 'sdgReport']);
        Route::get('/carbon-report/data', [ReportController::class, 'carbonReport']);
        Route::get('/sdg-report-view/{row_id}', [ReportController::class, 'sdgReportView']);
        Route::get('/carbon-report-view/{row_id}', [ReportController::class, 'sdgCarbonView']);
    });
    



    
});
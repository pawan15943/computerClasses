<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\StudentAssetController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Models\StudentAsset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::view('/', 'auth.login');

Auth::routes();
Route::get('/test', function () {
    return 'Test route working!';
});


Route::get('/user', [UserController::class, 'index'])->name('user');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [ProfileController::class, 'updatePassword'])->name('update-password');
    
    Route::get('/my_transaction', [UserController::class, 'my_transaction'])->name('my_transaction');
    Route::get('/stateGetConutryWise', [CityController::class, 'countryWiseState'])->name('stateGetConutryWise');
    Route::get('/cityGetStateWise', [ProfileController::class, 'stateWiseCity'])->name('cityGetStateWise');

    Route::get('/role', [RoleController::class, 'index'])->name('role');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('role/destroy', [RoleController::class, 'destroy'])->name('role.destroy');
    Route::middleware(['auth', 'role:admin'])->group(function () {
       

        Route::get('/post', [PostController::class, 'index'])->name('post');
        Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
        Route::get('/post/edit', [PostController::class, 'edit'])->name('post.edit');
        Route::post('post/destroy', [PostController::class, 'destroy'])->name('post.destroy');
       
        Route::get('/country', [CountryController::class, 'index'])->name('country');
        Route::post('/country/store', [CountryController::class, 'store'])->name('country.store');
        Route::get('/country/edit', [CountryController::class, 'edit'])->name('country.edit');
        Route::post('country/destroy', [CountryController::class, 'destroy'])->name('country.destroy');

        Route::get('/state', [StateController::class, 'index'])->name('state');
        Route::post('/state/store', [StateController::class, 'store'])->name('state.store');
        Route::get('/state/edit', [StateController::class, 'edit'])->name('state.edit');
        Route::delete('state/{id}', [StateController::class, 'destroy'])->name('state.destroy');

        Route::get('/city', [CityController::class, 'index'])->name('city');
        Route::post('/city/store', [CityController::class, 'store'])->name('city.store');
        Route::get('/city/edit', [CityController::class, 'edit'])->name('city.edit');
        Route::post('city/destroy', [CityController::class, 'destroy'])->name('city.destroy');

        Route::get('/class', [GradeController::class, 'index'])->name('class');
        Route::post('/class/store', [GradeController::class, 'store'])->name('class.store');
        Route::get('/class/edit', [GradeController::class, 'edit'])->name('class.edit');
        Route::post('class/destroy', [GradeController::class, 'destroy'])->name('class.destroy');

        Route::get('/course', [CourseController::class, 'index'])->name('course');
        Route::post('/course/store', [CourseController::class, 'store'])->name('course.store');
        Route::get('/course/edit', [CourseController::class, 'edit'])->name('course.edit');
        Route::post('course/destroy', [CourseController::class, 'destroy'])->name('course.destroy');

        Route::get('/student_assets', [StudentAssetController::class, 'index'])->name('student_assets');
        Route::post('/student_assets/store', [StudentAssetController::class, 'store'])->name('student_assets.store');
        Route::get('/student_assets/edit', [StudentAssetController::class, 'edit'])->name('student_assets.edit');
        Route::post('student_assets/destroy', [StudentAssetController::class, 'destroy'])->name('student_assets.destroy');
        Route::get('/userList', [UserController::class, 'user_list'])->name('userList');
        // Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('user/destroy', [UserController::class, 'destroy'])->name('user.destroy');
      
        Route::get('/studentList', [UserController::class, 'student_list'])->name('studentList');
        Route::get('/paymentVerify', [PaymentController::class, 'index'])->name('paymentVerify');
        Route::get('/paymentVerifyStatus', [PaymentController::class, 'verified'])->name('paymentVerifyStatus');
        Route::get('/transaction/view', [PaymentController::class, 'show'])->name('transaction.view');

    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/studentfees', [StudentController::class, 'index'])->name('studentfees');
   
    Route::get('/getCourseWiseFees', [StudentController::class, 'courseWiseFees'])->name('getCourseWiseFees');
    Route::get('/getUsereWiseFees', [StudentController::class, 'userWiseFees'])->name('getUsereWiseFees');
    Route::get('/initiatePayment', [StudentController::class, 'initiatePayment'])->name('initiatePayment');
    Route::get('/qrcodeview', [StudentController::class, 'create'])->name('qrcodeview');
    Route::post('/studentDetail/store', [StudentController::class, 'store'])->name('studentDetail.store');
    Route::post('/studentfees/store', [StudentController::class, 'studentfees_trans'])->name('studentfees.store');
    Route::middleware(['permission:edit posts'])->group(function () {
        // Routes accessible only to users with the 'edit posts' permission
        // Define your routes here
    });
    Route::get('/notification_list', [UserController::class, 'notification_list'])->name('notification_list');
});



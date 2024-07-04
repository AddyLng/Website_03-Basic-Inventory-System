<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// === Frequently Used Commands ===
// Route::get();
// Route::post();
// Route::put(); //remove then put another data
// Route::patch(); //small portion of data will be put
// Route::delete(); //delete the data
// Route::options(); //option-like setup for that process (specificity setup)

// ===========================================================================================

// Route::get('/users', [UserController::class, 'index'])->name('login'); //calls the controller class from the http
// //->name() is used for aliasing a route 

// Route::get('/user/{id}', [UserController::class,'show']); //calls the show id class from the http
// //->middleware() is a connecting like syntax that will cascade routes.
// //Ex. Route::get('/user/{id}', [UserController::class,'show'])->middleware('auth')

// Route::get('/student/{id}', [StudentController::class, 'show']);

// Route::get('/testing', function(){
//     return view('testing');
// });

//Common naming routes
//index - Show all data or student
//show - Show a singular student data
//create - Show a form to a new user
//store - Store a data
//edit - Show form to edit a data
//update - Update a data
//destroy - delete a dataw

Route::controller(UserController::class)->group(function(){
    Route::get('/register', 'register');
    Route::get('/login', 'login')->name('login')->middleware('guest');
    Route::post('/login/process', 'process');
    Route::post('/logout', 'logout');
    Route::post('/store','store');
});


Route::controller(StudentController::class)->group(function(){
    Route::get('/','index')->middleware('auth');
    Route::get('/add/student','create');
    Route::post('/add/student','store');
    Route::get('/student/{id}','show');
    Route::put('/student/{student}','update');
    Route::delete('/student/{student}','destroy');
});




<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function ($router) {
    Route::get('menu', 'MenuController@index');

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('register', 'AuthController@register'); 

    Route::group(['middleware' => 'admin'], function ($router) {
        Route::resource('users', 'UsersController')->except( ['create', 'store'] );
        Route::post('/users/add', 'UsersController@add');

        Route::prefix('menu/menu')->group(function () { 
            Route::get('/',         'MenuEditController@index')->name('menu.menu.index');
            Route::get('/create',   'MenuEditController@create')->name('menu.menu.create');
            Route::post('/store',   'MenuEditController@store')->name('menu.menu.store');
            Route::get('/edit',     'MenuEditController@edit')->name('menu.menu.edit');
            Route::post('/update',  'MenuEditController@update')->name('menu.menu.update');
            Route::get('/delete',   'MenuEditController@delete')->name('menu.menu.delete');
        });
        Route::prefix('menu/element')->group(function () { 
            Route::get('/',             'MenuElementController@index')->name('menu.index');
            Route::get('/move-up',      'MenuElementController@moveUp')->name('menu.up');
            Route::get('/move-down',    'MenuElementController@moveDown')->name('menu.down');
            Route::get('/create',       'MenuElementController@create')->name('menu.create');
            Route::post('/store',       'MenuElementController@store')->name('menu.store');
            Route::get('/get-parents',  'MenuElementController@getParents');
            Route::get('/edit',         'MenuElementController@edit')->name('menu.edit');
            Route::post('/update',      'MenuElementController@update')->name('menu.update');
            Route::get('/show',         'MenuElementController@show')->name('menu.show');
            Route::get('/delete',       'MenuElementController@delete')->name('menu.delete');
        });
        Route::prefix('media')->group(function ($router) {
            Route::get('/',                 'MediaController@index')->name('media.folder.index');
            Route::get('/folder/store',     'MediaController@folderAdd')->name('media.folder.add');
            Route::post('/folder/update',   'MediaController@folderUpdate')->name('media.folder.update');
            Route::get('/folder',           'MediaController@folder')->name('media.folder');
            Route::post('/folder/move',     'MediaController@folderMove')->name('media.folder.move');
            Route::post('/folder/delete',   'MediaController@folderDelete')->name('media.folder.delete');;

            Route::post('/file/store',      'MediaController@fileAdd')->name('media.file.add');
            Route::get('/file',             'MediaController@file');
            Route::post('/file/delete',     'MediaController@fileDelete')->name('media.file.delete');
            Route::post('/file/update',     'MediaController@fileUpdate')->name('media.file.update');
            Route::post('/file/move',       'MediaController@fileMove')->name('media.file.move');
            Route::post('/file/cropp',      'MediaController@cropp');
            Route::get('/file/copy',        'MediaController@fileCopy')->name('media.file.copy');

            Route::get('/file/download',    'MediaController@fileDownload');
        });

        Route::resource('roles',        'RolesController');
        Route::get('/roles/move/move-up',      'RolesController@moveUp')->name('roles.up');
        Route::get('/roles/move/move-down',    'RolesController@moveDown')->name('roles.down');
        Route::get('/language/{language}', 'LangController@setLanguage');
        Route::post('/upload/upload_file', 'UploadController@upload');
        
        Route::post('/config/products/list', 'ProductsController@list');
        Route::post('/config/products/add', 'ProductsController@add');
        Route::post('/config/products/update/{product_id}', 'ProductsController@update');
        Route::get('/config/products/detail/{product_id}', 'ProductsController@detail');
        Route::get('/config/products/delete/{product_id}', 'ProductsController@delete');
        Route::get('/config/products/get_all', 'ProductsController@getAll');
        Route::post('/config/branches/list', 'BranchesController@list');
        Route::post('/config/branches/add', 'BranchesController@add');
        Route::post('/config/branches/update/{branch_id}', 'BranchesController@update');
        Route::get('/config/branches/detail/{branch_id}', 'BranchesController@detail');
        Route::get('/config/branches/delete/{branch_id}', 'BranchesController@delete');
        Route::post('/config/classes/list', 'ClassesController@list');
        Route::post('/config/classes/add', 'ClassesController@add');
        Route::post('/config/classes/update/{class_id}', 'ClassesController@update');
        Route::get('/config/classes/detail/{class_id}', 'ClassesController@detail');
        Route::get('/config/classes/delete/{class_id}', 'ClassesController@delete');
        Route::get('/config/classes/get_data_by_keyword/{keyword}', 'ClassesController@getDataByKeyword');
        Route::post('/config/schedules/list', 'SchedulesController@list');
        Route::post('/config/schedules/add', 'SchedulesController@add');
        Route::post('/config/schedules/update/{class_id}', 'SchedulesController@update');
        Route::get('/config/schedules/detail/{class_id}', 'SchedulesController@detail');
        Route::get('/config/schedules/delete/{class_id}', 'SchedulesController@delete');
        Route::post('/config/tuition_fees/list', 'TuitionFeesController@list');
        Route::post('/config/tuition_fees/add', 'TuitionFeesController@add');
        Route::post('/config/tuition_fees/update/{tuiton_fee_id}', 'TuitionFeesController@update');
        Route::get('/config/tuition_fees/detail/{tuiton_fee_id}', 'TuitionFeesController@detail');
        Route::get('/config/tuition_fees/delete/{tuiton_fee_id}', 'TuitionFeesController@delete');
        Route::get('/config/shifts/get_all', 'ShiftsController@getAll');
        Route::get('/config/teachers/get_data_by_keyword/{keyword}', 'TeachersController@getDataByKeyword');

        Route::post('/courseware/quizs/list', 'QuizsController@list');
        Route::post('/courseware/quizs/add1', 'QuizsController@add1');
        Route::post('/courseware/quizs/update1/{quiz_id}', 'QuizsController@update1');
        Route::post('/courseware/quizs/add2', 'QuizsController@add2');
        Route::post('/courseware/quizs/update2/{quiz_id}', 'QuizsController@update2');
        Route::post('/courseware/quizs/add3', 'QuizsController@add3');
        Route::post('/courseware/quizs/update3/{quiz_id}', 'QuizsController@update3');
        Route::get('/courseware/quizs/detail/{quiz_id}', 'QuizsController@detail');
        Route::post('/courses/list', 'CoursesController@list');
        Route::post('/courses/add', 'CoursesController@add');
        Route::post('/courses/update/{course_id}', 'CoursesController@update');
        Route::get('/courses/detail/{course_id}', 'CoursesController@detail');
        Route::get('/courses/get_all', 'CoursesController@getAll');
        Route::post('/lessons/list', 'LessonsController@list');
        Route::post('/lessons/add', 'LessonsController@add');
        Route::post('/lessons/update/{lesson_id}', 'LessonsController@update');
        Route::get('/lessons/detail/{lesson_id}', 'LessonsController@detail');
        Route::post('/tests/list', 'TestsController@list');
        Route::post('/tests/add', 'TestsController@add');
        Route::post('/tests/update/{test_id}', 'TestsController@update');
        Route::get('/tests/detail/{test_id}', 'TestsController@detail');

        Route::get('/quiz/noidung_quiz/{quiz_id}', 'QuizsController@getNoiDungQuiz');
        Route::post('/quiz/answer', 'QuizsController@answerQuiz');
        
        Route::post('/students/list', 'StudentsController@list');
        Route::post('/students/add', 'StudentsController@add');
        Route::post('/students/update/{student_id}', 'StudentsController@update');
        Route::get('/students/detail/{student_id}', 'StudentsController@detail');
        Route::get('/students/delete/{student_id}', 'StudentsController@delete');
    });
});


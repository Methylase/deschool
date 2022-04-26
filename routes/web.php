<?php

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

Route::get('/signup','CoroxController@registerShowSignUp')->name('signup');
Route::post('/deschool/signup', 'CoroxController@registerSignUp');
Route::post('/deschool/login', 'CoroxController@registerLogin');
Route::post('/deschool/logout', 'CoroxController@logout' );
Route::get('/deschool/404', 'CoroxController@registerError404')->name('404');
Route::get('/', 'CoroxController@index')->name('login');
Route::get('/login', 'CoroxController@index')->name('login');
Route::get('/deschool/profile', 'CoroxController@registerProfile')->middleware('protectAdmin');
//Route::group(['middleware'=>'login'], function(){
Route::get('/deschool/staff-register', 'CoroxController@registerStaffRegister')->name('staff-register');
Route::post('/deschool/staff-register', 'CoroxController@registerStaffTimeRegister');
Route::get('/deschool/send-memo', 'CoroxController@getSendMemo')->name('send-memo')->middleware('protectAdmin');
Route::post('/deschool/send-memo', 'CoroxController@postSendMemo')->middleware('protectAdmin');
Route::get('/deschool/info-settings', 'CoroxController@registerInfoSettings')->name('info-settings')->middleware('protectAdmin');
Route::get('/deschool/add-staff', 'CoroxController@registerStaff')->name('add-staff')->middleware('protectAdmin');
Route::post('/deschool/add-info-settings', 'CoroxController@registerInfoSettingsAdd')->middleware('protectAdmin');
Route::put('/deschool/update-info-settings', 'CoroxController@registerInfoSettingsUpdate')->middleware('protectAdmin');
Route::get('/deschool/dashboard', 'CoroxController@registerDashboard')->name('dashboard');

Route::post('/deschool/add-staff', 'CoroxController@registerAddStaff')->middleware('protectAdmin');
Route::get('/deschool/edit-staff/{id}', 'CoroxController@registerEditStaff')->name('edit-staff')->middleware('protectMember');
Route::delete('/deschool/delete-staff/{id}', 'CoroxController@registerDeleteStaff')->middleware('protectMember');
Route::put('/deschool/update-staff', 'CoroxController@registerUpdateStaff')->middleware('protectMember');
Route::get('/deschool/view-staff-table', 'CoroxController@registerViewStaffTable')->name('view-staff')->middleware('protectMember');
Route::get('/deschool/view-staffs', 'CoroxController@registerViewStaffs' )->name('view-staffs')->middleware('protectAdmin');
Route::get('/deschool/priv-settings', 'CoroxController@registerPrivilegeSettings' )->middleware('protectAdmin');
Route::post('/deschool/privilege', 'CoroxController@registerPrivilege')->middleware('protectMember');
Route::post('/deschool/Enable/settings-information', 'CoroxController@registerPrivilegeEnableSettings')->middleware('protectMember');
Route::get('/deschool/general-settings', 'CoroxController@registerGeneralSettings')->name('general-settings')->middleware('protectAdmin');
Route::post('/deschool/add-subject', 'CoroxController@registerAddSubject')->middleware('protectMember');
Route::post('/deschool/add-class', 'CoroxController@registerAddClass')->middleware('protectMember');
Route::post('/deschool/add-period', 'CoroxController@registerAddPeriod')->middleware('protectMember');
Route::get('/deschool/assign-subject', 'CoroxController@registerAssignSubject')->name('assign-subject')->middleware('protectMember');
Route::get('/deschool/teacher', 'CoroxController@registerTeacher')->name('teacher')->middleware('protectAdmin');
Route::post('/deschool/add-teacher', 'CoroxController@registerAddTeacher')->middleware('protectAdmin');
Route::delete('/deschool/delete-teacher/{id}', 'CoroxController@registerDeleteTeacher')->middleware('protectAdmin');
Route::post('/deschool/update-teacher', 'CoroxController@registerUpdateTeacher')->middleware('protectAdmin');
Route::get('/deschool/add-student', 'CoroxController@registerStudent')->name('add-student')->middleware('protectAdmin');
Route::post('/deschool/add-student', 'CoroxController@registerAddStudent');
Route::get('/deschool/edit-student/{id}', 'CoroxController@registerEditStudent')->name('edit-student')->middleware('protectAdmin');
Route::put('/deschool/update-student', 'CoroxController@registerUpdateStudent')->middleware('protectAdmin');
Route::get('/deschool/view-students', 'CoroxController@registerViewStudents')->name('view-students');
Route::delete('/deschool/delete-student/{id}', 'CoroxController@registerDeleteStudent')->middleware('protectAdmin');
Route::get('/deschool/students-register', 'CoroxController@registerStudentRegister')->name('student-register');
Route::post('/deschool/students-register', 'CoroxController@registerStudentRegisterTable');
Route::get('/deschool/add-parent', 'CoroxController@registerParent')->name('add-parent')->middleware('protectAdmin');
Route::post('/deschool/add-parent', 'CoroxController@registerAddParent')->middleware('protectAdmin');
Route::get('/deschool/edit-parent/{id}', 'CoroxController@registerEditParent')->name('edit-parent')->middleware('protectAdmin');
Route::delete('/deschool/delete-parent/{id}', 'CoroxController@registerDeleteParent')->middleware('protectAdmin');
Route::get('/deschool/view-parents', 'CoroxController@registerViewParents')->name('view-parents');
Route::put('/deschool/update-parent', 'CoroxController@registerUpdateParent')->middleware('protectAdmin');
//Route::get('/Dregister/staff-register', 'coroxController@registerStaffTimeRegister');
Route::get('/deschool/mail/{id}', 'CoroxController@mailOut');
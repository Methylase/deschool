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

Route::get('/Dregister/signup','CoroxController@registerShowSignUp')->name('signup');
Route::post('/Dregister/signup', 'CoroxController@registerSignUp');
Route::post('/Dregister/login', 'CoroxController@registerLogin');
Route::post('/Dregister/logout', 'CoroxController@logout' );
Route::get('/Dregister/404', 'CoroxController@registerError404')->name('404');
Route::get('/', 'CoroxController@index')->name('login');
Route::get('/login', 'CoroxController@index')->name('login');
Route::get('/Dregister/profile', 'CoroxController@registerProfile')->middleware('protectAdmin');
//Route::group(['middleware'=>'login'], function(){
Route::get('/Dregister/staff-register', 'CoroxController@registerStaffRegister')->name('staff-register');
Route::post('/Dregister/staff-register', 'CoroxController@registerStaffTimeRegister');
Route::get('/Dregister/send-memo', 'CoroxController@getSendMemo')->name('send-memo')->middleware('protectAdmin');
Route::post('/Dregister/send-memo', 'CoroxController@postSendMemo')->middleware('protectAdmin');
Route::get('/Dregister/info-settings', 'CoroxController@registerInfoSettings')->name('info-settings')->middleware('protectAdmin');
Route::get('/Dregister/add-staff', 'CoroxController@registerStaff')->name('add-staff')->middleware('protectAdmin');
Route::post('/Dregister/add-info-settings', 'CoroxController@registerInfoSettingsAdd')->middleware('protectAdmin');
Route::put('/Dregister/update-info-settings', 'CoroxController@registerInfoSettingsUpdate')->middleware('protectAdmin');
Route::get('/Dregister/dashboard', 'CoroxController@registerDashboard')->name('dashboard');

Route::post('/Dregister/add-staff', 'CoroxController@registerAddStaff')->middleware('protectAdmin');
Route::get('/Dregister/edit-staff/{id}', 'CoroxController@registerEditStaff')->name('edit-staff')->middleware('protectMember');
Route::delete('/Dregister/delete-staff/{id}', 'CoroxController@registerDeleteStaff')->middleware('protectMember');
Route::put('/Dregister/update-staff', 'CoroxController@registerUpdateStaff')->middleware('protectMember');
Route::get('/Dregister/view-staff-table', 'CoroxController@registerViewStaffTable')->name('view-staff')->middleware('protectMember');
Route::get('/Dregister/view-staffs', 'CoroxController@registerViewStaffs' )->name('view-staffs')->middleware('protectAdmin');
Route::get('/Dregister/priv-settings', 'CoroxController@registerPrivilegeSettings' )->middleware('protectAdmin');
Route::post('/Dregister/privilege', 'CoroxController@registerPrivilege')->middleware('protectMember');
Route::post('/Dregister/Enable/settings-information', 'CoroxController@registerPrivilegeEnableSettings')->middleware('protectMember');
Route::get('/Dregister/general-settings', 'CoroxController@registerGeneralSettings')->name('general-settings')->middleware('protectAdmin');
Route::post('/Dregister/add-subject', 'CoroxController@registerAddSubject')->middleware('protectMember');
Route::post('/Dregister/add-class', 'CoroxController@registerAddClass')->middleware('protectMember');
Route::post('/Dregister/add-period', 'CoroxController@registerAddPeriod')->middleware('protectMember');
Route::get('/Dregister/assign-subject', 'CoroxController@registerAssignSubject')->name('assign-subject')->middleware('protectMember');
Route::get('/Dregister/teacher', 'CoroxController@registerTeacher')->name('teacher')->middleware('protectAdmin');
Route::post('/Dregister/add-teacher', 'CoroxController@registerAddTeacher')->middleware('protectAdmin');
Route::delete('/Dregister/delete-teacher/{id}', 'CoroxController@registerDeleteTeacher')->middleware('protectAdmin');
Route::post('/Dregister/update-teacher', 'CoroxController@registerUpdateTeacher')->middleware('protectAdmin');
Route::get('/Dregister/add-student', 'CoroxController@registerStudent')->name('add-student')->middleware('protectAdmin');
Route::post('/Dregister/add-student', 'CoroxController@registerAddStudent');
Route::get('/Dregister/edit-student/{id}', 'CoroxController@registerEditStudent')->name('edit-student')->middleware('protectAdmin');
Route::put('/Dregister/update-student', 'CoroxController@registerUpdateStudent')->middleware('protectAdmin');
Route::get('/Dregister/view-students', 'CoroxController@registerViewStudents')->name('view-students');
Route::delete('/Dregister/delete-student/{id}', 'CoroxController@registerDeleteStudent')->middleware('protectAdmin');
Route::get('/Dregister/students-register', 'CoroxController@registerStudentRegister')->name('student-register');
Route::post('/Dregister/students-register', 'CoroxController@registerStudentRegisterTable');
Route::get('/Dregister/add-parent', 'CoroxController@registerParent')->name('add-parent')->middleware('protectAdmin');
Route::post('/Dregister/add-parent', 'CoroxController@registerAddParent')->middleware('protectAdmin');
Route::get('/Dregister/edit-parent/{id}', 'CoroxController@registerEditParent')->name('edit-parent')->middleware('protectAdmin');
Route::delete('/Dregister/delete-parent/{id}', 'CoroxController@registerDeleteParent')->middleware('protectAdmin');
Route::get('/Dregister/view-parents', 'CoroxController@registerViewParents')->name('view-parents');
Route::put('/Dregister/update-parent', 'CoroxController@registerUpdateParent')->middleware('protectAdmin');
//Route::get('/Dregister/staff-register', 'coroxController@registerStaffTimeRegister');
Route::get('/Dregister/mail/{id}', 'CoroxController@mailOut');


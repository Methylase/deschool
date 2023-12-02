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
Route::group(['middleware'=>'guest'], function(){
Route::get('/signup','CoroxController@registerShowSignUp')->name('signup');

Route::post('/deschool/signup', 'CoroxController@registerSignUp');

Route::post('/deschool/login', 'CoroxController@registerLogin');

Route::get('/deschool/404', 'CoroxController@registerError404')->name('404');

Route::get('/', 'CoroxController@index')->name('login');

Route::get('/deschool', 'CoroxController@index')->name('login');

Route::get('/login', 'CoroxController@index')->name('login');
}); 

//logout
Route::post('/deschool/logout', 'CoroxController@logout')->name('logout');

Route::group(['middleware'=>'auth'], function(){
Route::get('/deschool/staff-register', 'CoroxController@registerStaffRegister')->name('staff-register');

Route::post('/deschool/staff-register', 'CoroxController@registerStaffTimeRegister');

Route::get('/deschool/students-register', 'CoroxController@registerStudentRegister')->name('students-register');

Route::post('/deschool/students-register', 'CoroxController@registerStudentTimeRegister');

Route::post('/deschool/send-memo', 'CoroxController@postSendMemo');

Route::post('/deschool/add-info-settings', 'CoroxController@registerInfoSettingsAdd');

Route::put('/deschool/update-info-settings', 'CoroxController@registerInfoSettingsUpdate');

Route::get('/deschool/dashboard', 'CoroxController@registerDashboard')->name('dashboard');

Route::post('/deschool/add-staff', 'CoroxController@registerAddStaff');

Route::delete('/deschool/delete-staff/{id}', 'CoroxController@registerDeleteStaff');

Route::put('/deschool/update-staff', 'CoroxController@registerUpdateStaff');

Route::post('/deschool/privilege', 'CoroxController@registerPrivilege');

Route::post('/deschool/academic_session', 'CoroxController@registerAcademicSession');

Route::post('/deschool/Enable/settings-information', 'CoroxController@registerPrivilegeEnableSettings');

Route::get('/deschool/add-subject', 'CoroxController@registerAddSubject');  

Route::post('/deschool/add-subject', 'CoroxController@registerAddSubject');

Route::get('/deschool/add-class', 'CoroxController@registerAddClass'); 

Route::post('/deschool/add-class', 'CoroxController@registerAddClass');

Route::get('/deschool/add-period', 'CoroxController@registerAddPeriod'); 

Route::post('/deschool/add-period', 'CoroxController@registerAddPeriod');

Route::post('/deschool/add-teacher', 'CoroxController@registerAddTeacher');

Route::post('/deschool/update-teacher', 'CoroxController@registerUpdateTeacher');

Route::post('/deschool/add-student', 'CoroxController@registerAddStudent');

Route::put('/deschool/update-student', 'CoroxController@registerUpdateStudent');

Route::get('/deschool/view-students', 'CoroxController@registerViewStudents')->name('view-students');

Route::delete('/deschool/delete-student/{id}', 'CoroxController@registerDeleteStudent');

Route::post('/deschool/students-registers', 'CoroxController@registerStudentRegisterTable');

Route::post('/deschool/add-parent', 'CoroxController@registerAddParent');

Route::delete('/deschool/delete-parent/{id}', 'CoroxController@registerDeleteParent');

Route::put('/deschool/update-parent', 'CoroxController@registerUpdateParent');

Route::get('/deschool/mail/{id}', 'CoroxController@mailOut');

Route::get('/deschool/view-staff-table', 'CoroxController@registerViewStaffTable')->name('view-staff')->middleware('protectMember');
});    

Route::group(['middleware'=>['protectAdmin','auth']], function(){

    Route::get('/deschool/profile', 'CoroxController@registerProfile')->name('profile');
    
    Route::get('/deschool/send-memo', 'CoroxController@getSendMemo')->name('send-memo')->middleware('protectAdmin');

    Route::get('/deschool/select-subject', 'CoroxController@registerSelectSubject')->name('select-subject')->middleware('protectAdmin');   

    Route::post('/deschool/select-subject', 'CoroxController@registerSelectSubject');    

    Route::get('/deschool/info-settings', 'CoroxController@registerInfoSettings')->name('info-settings')->middleware('protectAdmin');
   
    Route::get('/deschool/add-staff', 'CoroxController@registerStaff')->name('add-staff')->middleware('protectAdmin');
    
    Route::get('/add','CoroxController@add_it')->name('add_it')->middleware('protectAdmin');
    
    Route::get('/deschool/edit-staff/{id}', 'CoroxController@registerEditStaff')->name('edit-staff')->middleware('protectAdmin');
   
    Route::get('/deschool/view-staffs', 'CoroxController@registerViewStaffs')->name('view-staffs')->middleware('protectAdmin');    
    
    Route::get('/deschool/stationeries', 'CoroxController@registerStationeries')->name('stationeries')->middleware('protectAdmin');

    Route::post('/deschool/stationeries', 'CoroxController@registerStationeries');   

    Route::get('/deschool/assign-book', 'CoroxController@registerAssignBook')->name('assign-book')->middleware('protectAdmin');    

    Route::post('/deschool/assign-book', 'CoroxController@registerAssignBook');  

    Route::post('/deschool/assign-status', 'CoroxController@registerAssignStatus');   
    
    Route::post('/deschool/book-condition', 'CoroxController@registerBookCondition');    
    
    Route::get('/deschool/result-aggregator', 'CoroxController@registerResultAggregator')->name('result-aggregator')->middleware('protectAdmin');    

    Route::post('/deschool/result-aggregator', 'CoroxController@registerResultAggregator'); 

    Route::post('/deschool/change-student', 'CoroxController@registerChangeStudent');      

    Route::get('/deschool/result-estimator', 'CoroxController@registerResultEstimator')->name('result-estimator')->middleware('protectAdmin');        

    Route::post('/deschool/result-estimator', 'CoroxController@registerResultEstimator');

    Route::post('/deschool/change-class', 'CoroxController@registerChangeClass');   
   
    Route::get('/deschool/view-staff/{id}', 'CoroxController@registerViewStaff')->name('view-staff')->middleware('protectAdmin');
   
    Route::get('/deschool/setting-privilege', 'CoroxController@registerPrivilegeSettings' )->name('setting-privilege')->middleware('protectAdmin');
    
    Route::get('/deschool/class-setup', 'CoroxController@registerClassSetup')->name('class-setup')->middleware('protectAdmin');

    Route::get('/deschool/class-status', 'CoroxController@registerClassStatus')->name('class-status')->middleware('protectAdmin');    
    
    Route::get('/deschool/assign-subject', 'CoroxController@registerAssignSubject')->name('assign-subject')->middleware('protectAdmin');

    Route::post('/deschool/assign-subject', 'CoroxController@registerAssignSubject');   

    Route::post('/deschool/class-status', 'CoroxController@registerClassStatus');

    Route::get('/deschool/teacher', 'CoroxController@registerTeacher')->name('teacher')->middleware('protectAdmin');
    
    Route::delete('/deschool/delete-teacher/{id}', 'CoroxController@registerDeleteTeacher')->middleware('protectAdmin');
    
    Route::get('/deschool/add-student', 'CoroxController@registerStudent')->name('add-student')->middleware('protectAdmin');
    
    Route::get('/deschool/edit-student/{id}', 'CoroxController@registerEditStudent')->name('edit-student')->middleware('protectAdmin');

    Route::get('/deschool/add-parent', 'CoroxController@registerParent')->name('add-parent')->middleware('protectAdmin');
    
    Route::get('/deschool/edit-parent/{id}', 'CoroxController@registerEditParent')->name('edit-parent')->middleware('protectAdmin');
    
    Route::get('/deschool/view-parents', 'CoroxController@registerViewParents')->name('view-parents')->middleware('protectAdmin');    

    Route::get('/deschool/record-sales', 'CoroxController@registerRecordSales')->name('record-sales')->middleware('protectAdmin');     
    
    Route::post('/deschool/record-sales', 'CoroxController@registerRecordSales');
    
    Route::post('/deschool/mark', 'CoroxController@registerMark');   

    Route::get('/deschool/view-marks', 'CoroxController@registerViewMarks')->name('view-marks');      
    
    Route::post('/deschool/change-class-name', 'CoroxController@registerChangeClassName');   
    
    Route::post('/deschool/change-student-name', 'CoroxController@registerChangeStudentName');

    Route::get('/deschool/payments', 'CoroxController@registerPayment')->name('payments');      
    
    Route::post('/deschool/payments', 'CoroxController@registerPayment'); 

    Route::get('/deschool/earning-monthly', 'CoroxController@registerEarningMonthly');

    Route::get('/deschool/earning-annually', 'CoroxController@registerEarningAnnually');  
    
    Route::get('/deschool/stationeries-sales', 'CoroxController@registerYearlyStationeries'); 
    
    Route::get('/deschool/recovered-fees', 'CoroxController@registerRecoveredFees');   
    
    Route::get('/deschool/get-chart', 'CoroxController@registerGetChart'); 
});    



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

    Route::get('/about','CoroxController@AboutUs')->name('about');

    Route::get('/testimony','CoroxController@testimony')->name('testimony');

    Route::get('/contact','CoroxController@ContactUs')->name('contact');
    
    Route::post('/contact','CoroxController@ContactUs');

    Route::post('/newsletter','CoroxController@newsletter');
    
    Route::get('/privacy-policy','CoroxController@privacyPolicy')->name('privacy-policy');

    Route::get('/mission','CoroxController@mission')->name('mission');

    Route::get('/vision','CoroxController@vision')->name('vision');

    Route::get('/blog','CoroxController@blog')->name('blog');

    Route::get('/blog-post/{id?}','CoroxController@blogPost')->name('blog-post');

    Route::post('/blogs/{id}/comments', 'CoroxController@comments');

    Route::post('/comments/{comment}/reply', 'CoroxController@reply')->name('reply');

    Route::post('/comment', 'CoroxController@registerComment')->name('comment');

    Route::post('/signup', 'CoroxController@registerSignUp');

    Route::post('/login', 'CoroxController@registerLogin');

    Route::post('/booked','CoroxController@booked')->name('booked');

    Route::get('/404', 'CoroxController@registerError404')->name('404');

    Route::get('/', 'CoroxController@index')->name('home');

    Route::get('/login', 'CoroxController@login')->name('login');

    Route::get('/forgot-password', 'CoroxController@registerForgotPassword')->name('forgot-password');

    Route::post('/forgot-password', 'CoroxController@registerForgotPassword');

    Route::get('/change-password/{name}', 'CoroxController@registerChangePassword')->name('change-password')->where('name','.*');

    Route::post('/password', 'CoroxController@registerPassword');

}); 

Route::post('/logout', 'CoroxController@registerLogout')->name('logout');

Route::group(['middleware'=>'auth'], function(){
    Route::get('/staff-register', 'CoroxController@registerStaffRegister')->name('staff-register')->middleware('protectAdmin');

    Route::post('/staff-register', 'CoroxController@registerStaffTimeRegister');

    Route::get('/students-register', 'CoroxController@registerStudentRegister')->name('students-register');

    Route::post('/students-register', 'CoroxController@registerStudentTimeRegister');

    Route::post('/send-memo', 'CoroxController@postSendMemo');

    Route::post('/add-info-settings', 'CoroxController@registerInfoSettingsAdd');

    Route::put('/update-info-settings', 'CoroxController@registerInfoSettingsUpdate');

    Route::get('/dashboard', 'CoroxController@registerDashboard')->name('dashboard');

    Route::post('/add-staff', 'CoroxController@registerAddStaff');

    Route::delete('/delete-staff/{id}', 'CoroxController@registerDeleteStaff');

    Route::put('/update-staff', 'CoroxController@registerUpdateStaff');

    Route::post('/privilege', 'CoroxController@registerPrivilege');

    Route::post('/academic_session', 'CoroxController@registerAcademicSession');

    Route::post('/Enable/settings-information', 'CoroxController@registerPrivilegeEnableSettings');

    Route::get('/deschool/add-subject', 'CoroxController@registerAddSubject');  

    Route::post('/add-subject', 'CoroxController@registerAddSubject');

    Route::get('/add-class', 'CoroxController@registerAddClass'); 

    Route::post('/add-class', 'CoroxController@registerAddClass');

    Route::get('/add-period', 'CoroxController@registerAddPeriod'); 

    Route::post('/add-period', 'CoroxController@registerAddPeriod');

    Route::post('/add-teacher', 'CoroxController@registerAddTeacher');

    Route::post('/update-teacher', 'CoroxController@registerUpdateTeacher');

    Route::post('/add-student', 'CoroxController@registerAddStudent');

    Route::put('/update-student', 'CoroxController@registerUpdateStudent');

    Route::get('/view-students', 'CoroxController@registerViewStudents')->name('view-students');

    Route::delete('/delete-student/{id}', 'CoroxController@registerDeleteStudent');

    Route::post('/students-registers', 'CoroxController@registerStudentRegisterTable');

    Route::post('/add-parent', 'CoroxController@registerAddParent');

    Route::delete('/delete-parent/{id}', 'CoroxController@registerDeleteParent');

    Route::put('/update-parent', 'CoroxController@registerUpdateParent');

    Route::get('/mail/{id}', 'CoroxController@mailOut');

    Route::get('/view-staff-table', 'CoroxController@registerViewStaffTable')->name('view-staff')->middleware('protectMember');  

    Route::get('/profile', 'CoroxController@registerProfile')->name('profile')->middleware('protectAdmin');

    Route::get('/send-memo', 'CoroxController@getSendMemo')->name('send-memo')->middleware('protectAdmin');

    Route::get('/select-subject', 'CoroxController@registerSelectSubject')->name('select-subject')->middleware('protectAdmin');   

    Route::post('/select-subject', 'CoroxController@registerSelectSubject');    

    Route::get('/info-settings', 'CoroxController@registerInfoSettings')->name('info-settings')->middleware('protectAdmin');

    Route::get('/add-staff', 'CoroxController@registerStaff')->name('add-staff')->middleware('protectAdmin');

    Route::get('/edit-staff/{id}', 'CoroxController@registerEditStaff')->name('edit-staff')->middleware('protectAdmin');

    Route::get('/view-staffs', 'CoroxController@registerViewStaffs')->name('view-staffs')->middleware('protectAdmin');    

    Route::get('/stationeries', 'CoroxController@registerStationeries')->name('stationeries')->middleware('protectAdmin');

    Route::post('/stationeries', 'CoroxController@registerStationeries');   

    Route::get('/assign-book', 'CoroxController@registerAssignBook')->name('assign-book')->middleware('protectAdmin');    

    Route::post('/assign-book', 'CoroxController@registerAssignBook');  

    Route::post('/assign-status', 'CoroxController@registerAssignStatus');   

    Route::post('/book-condition', 'CoroxController@registerBookCondition');    

    Route::get('/result-aggregator', 'CoroxController@registerResultAggregator')->name('result-aggregator')->middleware('protectAdmin');    

    Route::post('/result-aggregator', 'CoroxController@registerResultAggregator'); 

    Route::post('/change-student', 'CoroxController@registerChangeStudent');      

    Route::get('/result-estimator', 'CoroxController@registerResultEstimator')->name('result-estimator')->middleware('protectAdmin');        

    Route::post('/result-estimator', 'CoroxController@registerResultEstimator');

    Route::post('/change-class', 'CoroxController@registerChangeClass');   

    Route::get('/view-staff/{id}', 'CoroxController@registerViewStaff')->name('view-staff')->middleware('protectAdmin');

    Route::get('/setting-privilege', 'CoroxController@registerPrivilegeSettings' )->name('setting-privilege')->middleware('protectAdmin');

    Route::get('/class-setup', 'CoroxController@registerClassSetup')->name('class-setup')->middleware('protectAdmin');

    Route::get('/class-status', 'CoroxController@registerClassStatus')->name('class-status')->middleware('protectAdmin');    

    Route::get('/assign-subject', 'CoroxController@registerAssignSubject')->name('assign-subject')->middleware('protectAdmin');

    Route::post('/assign-subject', 'CoroxController@registerAssignSubject');   

    Route::post('/class-status', 'CoroxController@registerClassStatus');

    Route::get('/teacher', 'CoroxController@registerTeacher')->name('teacher')->middleware('protectAdmin');

    Route::delete('/delete-teacher/{id}', 'CoroxController@registerDeleteTeacher');

    Route::get('/add-student', 'CoroxController@registerStudent')->name('add-student');

    Route::get('/edit-student/{id}', 'CoroxController@registerEditStudent')->name('edit-student');

    Route::get('/add-parent', 'CoroxController@registerParent')->name('add-parent');

    Route::get('/edit-parent/{id}', 'CoroxController@registerEditParent')->name('edit-parent');

    Route::get('/view-parents', 'CoroxController@registerViewParents')->name('view-parents');    

    Route::get('/record-sales', 'CoroxController@registerRecordSales')->name('record-sales');     

    Route::post('/record-sales', 'CoroxController@registerRecordSales');

    Route::post('/mark', 'CoroxController@registerMark');   

    Route::get('/view-marks', 'CoroxController@registerViewMarks')->name('view-marks'); 

    Route::get('/edit-mark/{id}', 'CoroxController@registerEditMark')->name('edit-mark');

    Route::put('/update-mark', 'CoroxController@registerUpdateMark');

    Route::post('/change-class-name', 'CoroxController@registerChangeClassName');   

    Route::post('/change-student-name', 'CoroxController@registerChangeStudentName');

    Route::get('/payments', 'CoroxController@registerPayment')->name('payments');      

    Route::post('/payments', 'CoroxController@registerPayment'); 

    Route::get('/earning-monthly', 'CoroxController@registerEarningMonthly');

    Route::get('/earning-annually', 'CoroxController@registerEarningAnnually');  

    Route::get('/stationeries-sales', 'CoroxController@registerYearlyStationeries'); 

    Route::get('/recovered-fees', 'CoroxController@registerRecoveredFees');   

    Route::get('/get-chart', 'CoroxController@registerGetChart'); 

    Route::get('/reset-password', 'CoroxController@registerResetPassword')->name('reset-password')->middleware('protectAdmin');
        
    Route::post('/reset-password', 'CoroxController@registerResetPassword');   

    Route::get('/post', 'CoroxController@registerBlogPost')->name('post')->middleware('protectAdmin');

    Route::post('/post', 'CoroxController@registerBlogPost')->middleware('protectAdmin');

    Route::get('/posts', 'CoroxController@registerPosts')->name('posts')->middleware('protectAdmin');

    Route::get('/edit-blog-post/{blog}', 'CoroxController@registerEditBlogPost')->name('edit-blog-post')->where('blog','.*')->middleware('protectAdmin');

    Route::put('/update-blog-post', 'CoroxController@registerUpdateBlogPost')->middleware('protectAdmin');

    Route::delete('/delete-blog-post/{blog}', 'CoroxController@registerDeleteBlogPost')->name('delete-blog-post')->middleware('protectAdmin');
    
    Route::get('/get_pie_chart', 'CoroxController@get_pie_chart')->middleware('protectAdmin');

    Route::get('/get_chart_data', 'CoroxController@getChartData')->middleware('protectAdmin');
    
});    



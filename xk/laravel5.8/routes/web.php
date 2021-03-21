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

Route::get('/', function () {
    return view('welcome');
});
//登录页面路由
Route::match(['get','post'],'login','xk\LoginController@login');
//注册页面路由
Route::get('register','xk\loginController@register');
//处理注册路由
Route::post('xk/doregister','xk\loginController@doregister');
//验证码路由
Route::get('/code','xk\LoginController@code');
//处理登录路由
Route::post('xk/dologin','xk\LoginController@dologin');
//加密算法
Route::get('jiami','Admin\infoController@jiami');
//登录欢迎界面路由
Route::get('IndexWelcome','xk\LoginController@welcome');
//后台路由组
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'isLogin'],function(){
    //后台页面路由
    Route::get('index','infoController@index');
    //退出登录路由
    Route::get('logout','infoController@logout');
    //学生列表页面路由
    Route::get('studentList','infoController@studentList');
    //添加学生页面路由
    Route::get('addStudent','infoController@addStudent');
    //申请开课消息页面路由
    Route::get('news','infoController@news');
    //课程人数消息页面路由
    Route::get('courseNews','infoController@courseNews');
    //同意申请课程路由
    Route::post('agree/{id}','infoController@agree');
    //拒绝申请课程路由
    Route::post('disagree/{id}','infoController@disagree');
    //删除课程路由
    Route::post('delCourse/{id}','infoController@delCourse');
    //删除信息路由
    Route::post('delNews/{id}','infoController@delNews');
    //个人中心路由
    Route::get('person','infoController@person');
    //个人中心修改路由
    Route::post('editperson','infoController@editperson');
    //修改密码路由
    Route::any('editPass','infoController@editPass');
    //后台用户模块相关的路由
    Route::resource('student','StudentController');
    Route::post('student/del','StudentController@delAll');
    Route::post('student/change_p','StudentController@change_p');

    Route::resource('teacher','TeacherController');
    Route::post('teacher/del','TeacherController@delAll');
    Route::post('teacher/change_p','TeacherController@change_p');

    Route::resource('course','CourseController');
    Route::post('course/del','CourseController@delAll');
    Route::post('course/submit_c/{id}','CourseController@submit_c');
    Route::get('courseCj','CourseController@courseCj');
    //课程学生成绩列表页面路由
    Route::any('course/studentList/{id}','CourseController@studentList');
    //保存成绩路由
    Route::post('saveCj','CourseController@saveCj');
    //录入成绩路由
    Route::post('submitCj','CourseController@submitCj');
});

//学生选课路由组
Route::group(['prefix'=>'student','namespace'=>'Student','middleware'=>'isLogin'],function(){
    //主页面路由
    Route::get('index','infoController@index');
    //退出登录路由
    Route::get('logout','infoController@logout');
    //学生选课列表页面路由
    Route::get('xkList','infoController@xkList');
    //学生选择课程路由
    Route::post('courseSelect/{id}','infoController@courseSelect');
    //学生已选课程页面路由
    Route::get('selectedCourse','infoController@selectedCourse');
    //学生删除课程路由
    Route::post('courseDel/{id}','infoController@courseDel');
    //学生课程页面路由
    Route::get('studentCourse','infoController@studentCourse');
    //消息页面路由
    Route::get('news','infoController@news');
    //个人中心路由
    Route::get('person','infoController@person');
    //个人中心修改路由
    Route::post('editperson','infoController@editperson');
    //修改密码路由
    Route::any('editPass','infoController@editPass');

});

//教师管理路由组
Route::group(['prefix'=>'teacher','namespace'=>'Teacher','middleware'=>'isLogin'],function(){
    //主页面路由
    Route::get('index','infoController@index');
    //退出登录路由
    Route::get('logout','infoController@logout');
    //教师课程页面路由
    Route::get('teacherCourse','infoController@teacherCourse');
    //教师添加课程页面路由
    Route::get('addC','infoController@addC');
    //教师添加课程功能路由
    Route::post('addCourse','infoController@addCourse');
    //课程学生列表页面路由
    Route::any('studentList/{id}','infoController@studentList');
    //录入成绩路由
    Route::post('submitCj','infoController@submitCj');
    //保存成绩路由
    Route::post('saveCj','infoController@saveCj');
    //申请修改成绩路由
    Route::get('editCj/{id}','infoController@editCj');
    //申请消息页面路由
    Route::get('applynews','infoController@applynews');
    //删除申请信息路由
    Route::post('delNews/{id}','infoController@delNews');
    //撤回申请信息路由
    Route::post('delApply/{id}','infoController@delApply');
    //结束课程路由
    Route::get('endCourse/{id}','infoController@endCourse');
    //消息页面路由
    Route::get('news','infoController@news');
    //个人中心路由
    Route::get('person','infoController@person');
    //个人中心修改路由
    Route::post('editperson','infoController@editperson');
    //修改密码路由
    Route::any('editPass','infoController@editPass');

});

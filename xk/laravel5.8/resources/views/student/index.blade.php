<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="{{asset('css/font/css/ch-ui.admin.css')}}">
    <link rel="stylesheet" href="{{asset('css/font/css/font-awesome.min.css')}}">
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/ch-ui.admin.js')}}"></script>
</head>
<body>
	<!--头部 开始-->
	<div class="top_box">
		<div class="top_left">
			<div class="logo">学生选课系统</div>
			<!-- <ul>
				<li><a href="#" class="active">首页</a></li>
				<li><a href="#">管理页</a></li>
			</ul> -->
		</div>
		<div class="top_right">
			<ul>
				<li><a href="{{url('student/person')}}" target="main">学生：{{session('user')}}</a></li>
				<li><a href="{{url('student/editPass')}}" target="main">修改密码</a></li>
				<li><a href="{{url('student/logout')}}">退出</a></li>
			</ul>
		</div>
	</div>
	<!--头部 结束-->

	<!--左侧导航 开始-->
	<div class="menu_box">
		<ul>
            <li>
            	<h3><i class="fa fa-graduation-cap"></i>操作</h3>
                <ul class="sub_menu">
                    <li><a href="{{url('student/xkList')}}" target="main"><i class="fa fa-list"></i>选课</a></li>
                    <li><a href="{{url('student/selectedCourse')}}" target="main"><i class="fa fa-book"></i>已选课程</a></li>
                    <li><a href="{{url('student/studentCourse')}}" target="main"><i class="fa fa-book"></i>我的课程</a></li>
                    <li><a href="{{url('student/news')}}" target="main"><i class="fa fa-file-text-o"></i>消息列表</a></li>
                </ul>
            </li>


        </ul>
	</div>
	<!--左侧导航 结束-->

	<!--主体部分 开始-->
	<div class="main_box">
		<iframe src="{{url('IndexWelcome')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
	</div>
	<!--主体部分 结束-->

	<!--底部 开始-->
	<div class="bottom_box">

	</div>
	<!--底部 结束-->
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="{{asset('css/font/css/ch-ui.admin.css')}}">
	<link rel="stylesheet" href="{{asset('css/font/css/font-awesome.min.css')}}">
</head>
<body style="background:#F3F3F4;">
	<div class="login_box">
		<h1>gdcp</h1>
		<h2>欢迎使用学生选课平台</h2>
		<div class="form">
             @if(count($errors)>0)
             <div>
                <!-- @if(is_object($errors)) -->
                 @foreach($errors->all() as $error)
                 <p style="color: red;">{{$error}}</p>
                 @endforeach
                 <!-- @else -->
                <!-- <p style="color: red;">{{$error}}</p>
                 @endif -->

             </div>
            @endif
            @if(session('msg'))
             <div class="mark">
                 <p style="color: red;">{{session('msg')}}</p>
             </div>
             @endif
			<form action="{{ url('xk/doregister') }}" method="post">
                {{csrf_field()}}
                请选择用户类型:
                <select name="mySelect" style="width:100px; margin:20px 15px;">
                <option value="1">学生</option>
                <option value="2">教师</option>
                <option value="3">管理员</option>
                </select>
				<ul>
					<li>
					<input type="text" name="username" class="text" placeholder="用户名"/>
						<span><i class="fa fa-user"></i></span>
					</li>
					<li>
						<input type="password" name="password" class="text" placeholder="密码"/>
						<span><i class="fa fa-lock"></i></span>
					</li>
					<li>
						<input type="submit" value="立即注册"/>
					</li>

				</ul>
			</form>
		</div>
	</div>
</body>
</html>

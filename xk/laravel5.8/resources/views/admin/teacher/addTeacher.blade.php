<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="csrf-token" content="{{csrf_token()}}" >
	<link rel="stylesheet" href="{{asset('css/font/css/ch-ui.admin.css')}}">
    <link rel="stylesheet" href="{{asset('css/font/css/font-awesome.min.css')}}">
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/ch-ui.admin.js')}}"></script>
</head>
<body>
<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>添加教师</h3>

        @if(session('msg'))
        <div class="mark">
            <p>{{session('msg')}}</p>
        </div>
        @endif
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <a href="{{ url('admin/teacher') }}" style="float: right; width: 20px;height: 20px;"><i class="fa fa-times"></i></a>
    <form>
         <!-- method="post" action="{{ url('admin/student') }}" -->
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <table class="add_tab" style="width: 90%;margin: auto;">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>姓名：</th>
                <td>
                    <input type="text" name="username">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>密码：</th>
                <td>
                    <input type="text" name="password">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>性别：</th>
                <td>
                    <input type="text" name="gender">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>手机：</th>
                <td>
                    <input type="text" name="phone">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>学院：</th>
                <td>
                    <input type="text" name="college">
                </td>
            </tr>

            <tr>
                <td>
                    <input type="submit" name="add" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
</body>
<script>
    $('input[name="add"]').click(function(){
        var name=$("input[name='username']").val();
        var pw=$("input[name='password']").val();
        var gender=$("input[name='gender']").val();
        var phone=$("input[name='phone']").val();
        var college=$("input[name='college']").val();
        $.ajax({
            type:'POST',
            url:'/admin/teacher',
            dataType:'json',
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            data:{ username: name,password:pw,gender:gender,phone:phone,college:college},
            success:function(data){
                if(data.status==0){
                    // console.log(data.message);
                    alert(data.message);
                    window.history.back(-1);
                }else if(data.status==1){
                // console.log(data.message);
                alert(data.message);
            }else  if(data.status==2){
                alert(data.message);
            }

            },
        })

    })
</script>
</html>

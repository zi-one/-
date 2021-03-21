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
        <h3>修改学生</h3>

        @if(session('msg'))
        <div class="mark">
            <p>{{session('msg')}}</p>
        </div>
        @endif
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <a href="{{ url('admin/student') }}" style="float: right; width: 20px;height: 20px;"><i class="fa fa-times"></i></a>
    <form>
        <!-- method="put" action="{{ url('admin/student/'.$student->s_id) }}" -->
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <table class="add_tab" style="width: 90%;margin: auto;">
            <tbody>
                <input type="hidden" name="id" value="{{$student->s_id}}" />
            <tr>
                <th width="120"><i class="require">*</i>姓名：</th>
                <td>
                    <input type="text" name="username" value="{{$student->s_name}}"/>
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>密码：</th>
                <td>
                    <input type="text" name="password" value="{{Crypt::decrypt($student->s_pw)}}">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>性别：</th>
                <td>
                    <input type="text" name="gender" value="{{$student->s_gender}}">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>学号：</th>
                <td>
                    <input type="text" name="number" value="{{$student->s_number}}">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>手机：</th>
                <td>
                    <input type="text" name="phone" value="{{$student->s_phone}}">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>学院：</th>
                <td>
                    <input type="text" name="college" value="{{$student->s_college}}">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>班级：</th>
                <td>
                    <input type="text" name="class" value="{{$student->s_class}}">
                </td>
            </tr>

            <tr>
                <td>
                    <input type="submit" name="edit" value="修改">
                </td>
                <td>
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<script>
    $('input[name="edit"]').click(function(){
        var sid=$("input[name='id']").val();
        var name=$("input[name='username']").val();
        var pw=$("input[name='password']").val();
        var gender=$("input[name='gender']").val();
        var number=$("input[name='number']").val();
        var phone=$("input[name='phone']").val();
        var college=$("input[name='college']").val();
        var s_class=$("input[name='class']").val();
        $.ajax({
            type:'PUT',
            url:'/admin/student/'+sid,
            dataType:'json',
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            data:{ username: name,password:pw,gender:gender,number:number,phone:phone,college:college,s_class:s_class},
            success:function(data){
                if(data.status==0){
                    // console.log(data.message);
                    alert(data.message);
                    window.history.back(-1);
                }else if(data.status==1){
                // console.log(data.message);
                alert(data.message);
            }

            },
        })

    })
</script>
</body>
</html>

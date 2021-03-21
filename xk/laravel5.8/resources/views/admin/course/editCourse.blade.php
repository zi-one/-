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
        <h3>修改课程信息</h3>

        @if(session('msg'))
        <div class="mark">
            <p>{{session('msg')}}</p>
        </div>
        @endif
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <a href="{{ url('admin/course') }}" style="float: right; width: 20px;height: 20px;"><i class="fa fa-times"></i></a>
    <form>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <table class="add_tab" style="width: 90%;margin: auto;">
            <tbody>
                <input type="hidden" name="id" value="{{$course->c_id}}" />
            <tr>
                <th width="120"><i class="require">*</i>课程名：</th>
                <td>
                    <input type="text" name="cname" value="{{$course->c_name}}">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>授课教师：</th>
                <td>
                    <input type="text" name="tname" value="{{$course->t_name}}">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>课程类型：</th>
                <td>
                    <input type="text" name="ctype" value="{{$course->c_type}}">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>限选人数：</th>
                <td>
                    <input type="text" name="climit" value="{{$course->c_limit}}">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>截止时间：</th>
                <td>
                    <input type="date" name="cdate" value="{{$course->c_date}}">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>学分：</th>
                <td>
                    <input type="text" name="credit" value="{{$course->credit}}">
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
        var cname=$("input[name='cname']").val();
        var tname=$("input[name='tname']").val();
        var ctype=$("input[name='ctype']").val();
        var climit=$("input[name='climit']").val();
        var cdate=$("input[name='cdate']").val();
        var credit=$("input[name='credit']").val();
        $.ajax({
            type:'PUT',
            url:'/admin/course/'+sid,
            dataType:'json',
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            data:{ cname: cname,tname: tname,ctype: ctype,climit:climit,cdate:cdate,credit: credit},
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

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="csrf-token" content="{{csrf_token()}}" >
	<link rel="stylesheet" href="{{asset('css/font/css/ch-ui.admin.css')}}">
    <link rel="stylesheet" href="{{asset('css/font/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
    <script type="text/javascript" src="{{asset('layui/layui.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/ch-ui.admin.js')}}"></script>


</head>
<body>
<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>申请开课</h3>

        @if(session('msg'))
        <div class="mark">
            <p>{{session('msg')}}</p>
        </div>
        @endif
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <table class="add_tab" style="width: 90%;margin: auto;">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>课程名：</th>
                <td>
                    <input type="text" name="cname">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>课程类型：</th>
                <td>
                    <select name="ctype" style="width:160px;height: 25px;">
                        <option value="人文社科类">人文社科类</option>
                        <option value="创新创业类">创新创业类</option>
                        <option value="交通行业类">交通行业类</option>
                        <option value="自然科学与工程技术类">自然科学与工程技术类</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>限选人数：</th>
                <td>
                    <input type="text" name="climit">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>开课时间：</th>
                <td>
                    <input type="date" name="cdate">
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>学分：</th>
                <td>
                    <input type="text" name="credit">
                </td>
            </tr>


            <tr>
                <td></td>
                <td>
                    <input type="submit" name="add" onclick="return false" value="提交">

                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
</body>
<script>
    layui.use('layer', function(){
    $('input[name="add"]').click(function(){
        var cname=$("input[name='cname']").val();
        var ctype=$("select[name='ctype']").val();
        var climit=$("input[name='climit']").val();
        var cdate=$("input[name='cdate']").val();
        var credit=$("input[name='credit']").val();


        $.ajax({
            type:'POST',
            url:'/teacher/addCourse',
            dataType:'json',
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            data:{ cname: cname,ctype: ctype,climit:climit,cdate:cdate,credit: credit},
            success:function(data){
                if(data.status==0){
                    layer.msg(data.message, {
                        icon: 1,time: 3000
                    });
                }else if(data.status==1){
                    layer.msg(data.message, {
                        icon: 5,time: 2000
                    });
            }else if(data.status==3){
                    layer.msg(data.message, {
                        icon: 5,time: 2000
                    });
                }else{
                    layer.msg(data.message, {
                        icon: 5,time: 2000
                    });
                }

            },
        })
        })
    })
</script>
</html>

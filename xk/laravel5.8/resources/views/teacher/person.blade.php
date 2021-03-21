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

<div class="result_wrap">
    <form>
       <!-- <input type="hidden" name="_token" value="{{csrf_token()}}"> -->
        <table class="add_tab" style="width: 90%;margin: auto;">
            <tbody>
            <tr>
                <th width="120">姓名：</th>
                <td>
                    <input type="text" name="username" value="{{$teacher->t_name}}">
                </td>
            </tr>
            <tr>
                <th width="120">性别：</th>
                <td>
                    <input type="text" name="gender" value="{{$teacher->t_gender}}">
                </td>
            </tr>
            <tr>
                <th width="120">手机：</th>
                <td>
                    <input type="text" name="phone" value="{{$teacher->t_phone}}">
                </td>
            </tr>
            <tr>
                <th width="120">学院：</th>
                <td>
                    <input type="text" name="college" value="{{$teacher->t_college}}">
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" name="confirm" value="保存">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
</body>
<script>
    $('input[name="confirm"]').click(function(){
        var name=$("input[name='username']").val();
        var gender=$("input[name='gender']").val();
        var phone=$("input[name='phone']").val();
        var college=$("input[name='college']").val();

        $.ajax({
            type:'post',
            url:'editperson',
            dataType:'json',
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            data:{ username: name,gender:gender,phone:phone,college:college},
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
</html>

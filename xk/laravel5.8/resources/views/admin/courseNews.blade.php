<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layui/layui.js')}}"></script>
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('css/font/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/font/css/bootstrap.min.css')}}">
</head>
<body>


<TABLE border=1 cellspacing=0 bordercolor="#CCC" style=" width: 100%; " class="layui-table">
   <thead>
             <tr>

               <th>课程名</th>
               <th>课程老师</th>
               <th>消息内容</th>
               <th>操作</th>
               </tr>
           </thead>
            <tbody>
                @foreach($news as $n)
                     <tr>
                       <td>{{$n->c_name}}</td>
                       <td>{{$n->t_name}}</td>
                       <td>选课人数不足，无法开课！</td>
                       <td>
                         <input type="button" onclick="del_c(this,{{ $n->c_id}})" value="删除该课程" />
                       </td>
                     </tr>
                     @endforeach
                     </tbody>
</TABLE>
<div align="center">

</div>
</body>
<script>


    function del_c(obj,id){
        layui.use('layer', function(){
            var layer = layui.layer
            layer.confirm('你确定要删除吗?', {icon: 3, title:'提示'}, function(index){
            $.post('/admin/delCourse/'+id,{"_token":"{{csrf_token()}}"},function(data){
                if(data.status==0){
                    $(obj).parents("tr").remove();
                    layer.msg(data.message, {
                        icon: 1,time: 2000
                    });
                }else{
                    layer.msg(data.message, {
                        icon: 5,time: 2000
                    });
                }
            })
            })
            layer.close(index);
        })
    }
</script>
</html>

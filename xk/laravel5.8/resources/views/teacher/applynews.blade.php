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


<TABLE border=1 cellspacing=0 bordercolor="#CCC" style=" width: 100%;" class="layui-table">
   <thead>
             <tr>

               <th>课程名</th>
               <th>申请内容</th>
               <th>申请进度</th>
               <th>操作</th>
               </tr>
           </thead>
            <tbody>
                @foreach($news as $n)
                     <tr height="50px">
                       <td>{{$n->c_name}}</td>
                       <td>{{$n->c_content}}</td>
                       <td>
                           @if($n->c_status=='申请开课' || $n->c_status=='申请修改成绩')
                           待审核
                           @elseif($n->c_status=='不同意')
                           审核不通过
                           @else
                           通过
                           @endif
                       </td>
                       <td>
                           @if($n->c_status=='申请开课' || $n->c_status=='申请修改成绩')
                               <input class="layui-btn layui-btn-primary" type="button" onclick="del_apply(this,{{ $n->c_id}})" value="撤回申请"/>
                           @else
                               <a style="margin-left: 20px" href="#" onclick="del_c(this,{{ $n->c_id}})"><i class="fa fa-times"></i></a>
                           @endif
                       </td>
                     </tr>
                     @endforeach
           </tbody>
</TABLE>
</body>
<script>
    function del_c(obj,id){
            $.post('/teacher/delNews/'+id,{"_token":"{{csrf_token()}}"},function(data){
                if(data.status==0){
                    $(obj).parents("tr").remove();

                }
            })

    }


    function del_apply(obj,id){
        layui.use('layer', function(){
            var layer = layui.layer
        $.post('/teacher/delApply/'+id,{"_token":"{{csrf_token()}}"},function(data){
            if(data.status==0){
                $(obj).parents("tr").remove();
                layer.msg(data.message, {
                    icon: 1,time: 2000
                });
            }
            layer.close();
        });
        });

    }
</script>
</html>

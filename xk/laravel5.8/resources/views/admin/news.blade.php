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
               <th>课程老师</th>
               <th>消息内容</th>
               <th>审核状态</th>
               <th>操作</th>
               </tr>
           </thead>
            <tbody>
                @foreach($course as $c)
                     <tr>
                       <td>{{$c->c_name}}</td>
                       <td>{{$c->t_name}}</td>
                       <td>{{$c->c_content}}</td>
                       <td>
                          @if($c->c_status=='同意')
                          通过
                          @elseif($c->c_status=='不同意')
                          审核不通过
                          @else
                          待审核
                          @endif
                       </td>
                       <td>
                           @if($c->c_status=='同意' || $c->c_status=='不同意')
                           <a href="#" onclick="del_c(this,{{ $c->c_id}})"><i class="fa fa-times"></i></a>
                           @else
                           <input type="button" onclick="agree(this,{{ $c->c_id}})" value="同意" />
                           <input type="button" onclick="disagree(this,{{ $c->c_id}})" value="拒绝并退回申请"/>
                           @endif

                       </td>
                     </tr>
                     @endforeach


                     </tbody>
</TABLE>
<div align="center">

</div>
</body>
<script>
    function agree(obj,id){
        layui.use('layer', function(){
            var layer = layui.layer
            layer.confirm('你确定要同意该申请吗?', {icon: 3, title:'提示'}, function(index){
            $.post('/admin/agree/'+id,{"_token":"{{csrf_token()}}"},function(data){
                if(data.status==0 || data.status==4){
                    layer.msg(data.message, {
                        icon: 1,time: 2000
                    });
                }else{
                    layer.msg(data.message, {
                        icon: 5,time: 2000
                    });
                }
            })
                layer.close(index);
            })

        })
    };



    function disagree(obj,id){
        layui.use('layer', function(){
            var layer = layui.layer
            layer.confirm('确定拒绝该申请吗?', {icon: 3, title:'提示'}, function(index){
                $.post('/admin/disagree/'+id,{"_token":"{{csrf_token()}}"},function(data){
                    if(data.status==0){
                        layer.msg(data.message, {
                            icon: 1,time: 2000
                        });
                    }
                })
                layer.close(index);
            })

        })
    };

    function del_c(obj,id){
            $.post('/admin/delNews/'+id,{"_token":"{{csrf_token()}}"},function(data){
                if(data.status==0){
                    $(obj).parents("tr").remove();

                }
            })

    }
</script>
</html>

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
<div style="margin: 20px auto;">
    <form method="get" action="{{ url('student/selectedCourse') }}">
    <input type="text" name="username" value="{{$request->input('username')}}"  placeholder="请输入课程名">
    <button type="submit"><i class="fa fa-search"></i></button>
    <a href="{{url('student/selectedCourse')}}" style="float: right;font-size: 25px;margin: 0px 50px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
    </form>
     </div>

<TABLE border=1 cellspacing=0 bordercolor="#CCC" style=" width: 100%;" class="layui-table">
   <thead>
             <tr>
               <th>ID</th>
               <th>课程名</th>
               <th>课程老师</th>
               <th>课程类型</th>
               <th>学分</th>
               <th>课程状态</th>
               <th>操作</th></tr>
           </thead>
            <tbody>
                @foreach($selectedCourse as $sc)
                     <tr>
                       <td>{{$sc->c_id}}</td>
                       <td>{{$sc->c_name}}</td>
                       <td>{{$sc->t_name}}</td>
                       <td>{{$sc->c_type}}</td>
                       <td>{{$sc->credit}}</td>
                       <td>
                           @if($sc->c_status=='已发布')
                           已开始选课
                           @elseif($sc->c_status=='已满人')
                           已满人
                           @else
                           已结束选课
                           @endif
                       </td>
                       <td class="td-manage">
                         <input class="layui-btn layui-btn-primary" type="button" onclick="sc_del(this,{{ $sc->c_id}})" value="删除" />
                       </td>
                     </tr>
                     @endforeach
                     </tbody>
</TABLE>
<div align="center">
    {!! $selectedCourse->appends($request->all())->render() !!}
</div>
</body>
<script>

 function sc_del(obj,id){
     layui.use('layer', function(){
         var layer = layui.layer
         layer.confirm('确定要删除该课程吗?', {icon: 3, title:'提示'}, function(index){
            $.post('courseDel/'+id,{"_token":"{{csrf_token()}}"},function(data){
                if(data.status==0){
                    layer.msg(data.message, {
                        icon: 1,time: 2000
                    });
                    // window.location.reload();
                }else{
                    layer.msg(data.message, {
                        icon: 5,time: 2000
                    });
                }
            })
             layer.close(index);
         })

     });

    };


    {{--function sc_cj(obj,id){--}}
    {{--           $.post('course_cj/'+id,{"_token":"{{csrf_token()}}"},function(data){--}}
    {{--               alert(data);--}}
    {{--           })--}}


    {{--   };--}}



</script>
</html>

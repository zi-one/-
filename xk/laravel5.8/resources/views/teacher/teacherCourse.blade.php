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
    <link rel="stylesheet" href="{{asset('css/font/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/font/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
</head>
<body>
<div style="margin: 20px auto;">
    <form method="get" action="{{ url('teacher/teacherCourse') }}">
    <input type="text" name="username" value="{{$request->input('username')}}"  placeholder="请输入课程名">
    <button type="submit"><i class="fa fa-search"></i></button>
    <a href="{{url('teacher/teacherCourse')}}" style="float: right;font-size: 25px;margin: 0px 50px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
    </form>
     </div>

<TABLE border=1 cellspacing=0 bordercolor="#CCC" style=" width: 100%;" class="layui-table">
   <thead>
             <tr>
               <th>ID</th>
               <th>课程名</th>
               <th>课程老师</th>
               <th>课程类型</th>
               <th>课程人数</th>
               <th>学分</th>
               <th>课程状态</th>
               <th>操作</th></tr>
           </thead>
            <tbody>
                @foreach($teacherCourse as $tc)
                     <tr>
                       <td>{{$tc->c_id}}</td>
                       <td>{{$tc->c_name}}</td>
                       <td>{{$tc->t_name}}</td>
                       <td>{{$tc->c_type}}</td>
                       <td>{{$tc->c_select}}</td>
                       <td>{{$tc->credit}}</td>
                       <td>
                           @if($tc->c_status=='已发布')
                           已开始选课
                           @elseif($tc->c_status=='已满人')
                           已满人
                           @elseif($tc->c_status=='选课已结束')
                           课程已开始
                           @elseif($tc->c_status=='已结课')
                           课程已结束
                           @endif
                       </td>
                       <td class="td-manage">
                         <input class="layui-btn layui-btn-primary" type="button" onclick="tc_cj(this,{{ $tc->c_id}})" value="录入成绩" />
                         <input class="layui-btn layui-btn-primary" type="submit" onclick="edit_cj(this,{{ $tc->c_id}})" value="申请修改成绩 " />
                         @if($tc->c_status!='已结课')
                         <input class="layui-btn layui-btn-primary" type="submit" onclick="end_c(this,{{ $tc->c_id}})" value="结束课程 " />
                         @else

                         @endif
                       </td>
                     </tr>
                     @endforeach
                     </tbody>
</TABLE>
<div align="center">
    {!! $teacherCourse->appends($request->all())->render() !!}
</div>
</body>
<script>



 function tc_cj(obj,id){
            $.get('studentList/'+id,function(data){

                    window.location.href = "/teacher/studentList/"+id;

            })


    };


 function edit_cj(obj,id){

     layui.use('layer', function(){
         var layer = layui.layer
         layer.confirm('确定申请修改成绩吗?', {icon: 3, title:'提示'}, function(index){
             $.get('/teacher/editCj/'+id,function(data){
                 if(data.status==0){
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
         });
     });


 };

 function end_c(obj,id){
     layui.use('layer', function(){
         var layer = layui.layer
         layer.confirm('确定结束课程吗?', {icon: 3, title:'提示'}, function(index){
         $.get('/teacher/endCourse/'+id,function(data){
             if(data.status==0){
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
         });
     });
 };
</script>
</html>

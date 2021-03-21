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
    <form method="get" action="{{ url('admin/courseCj') }}">
    <input type="text" name="username" value="{{$request->input('username')}}"  placeholder="请输入课程名">
    <button type="submit"><i class="fa fa-search"></i></button>
    <a href="{{url('admin/courseCj')}}" style="float: right;font-size: 25px;margin: 0px 50px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
    </form>
     </div>

<TABLE border=1 cellspacing=0 bordercolor="#CCC" style=" width: 100%;" class="layui-table">
   <thead>
             <tr>
               <th>ID</th>
               <th>课程名</th>
               <th>课程老师</th>
               <th>课程类型</th>
               <th>已选</th>
               <th>限选</th>
               <th>开课时间</th>
               <th>学分</th>
               <th>课程状态</th>
               <th>操作</th>
               </tr>
           </thead>
            <tbody>
                @foreach($course as $c)
                     <tr>
                       <td>{{$c->c_id}}</td>
                       <td>{{$c->c_name}}</td>
                       <td>{{$c->t_name}}</td>
                       <td>{{$c->c_type}}</td>
                       <td>{{$c->c_select}}</td>
                       <td>{{$c->c_limit}}</td>
                       <td>{{$c->c_date}}</td>
                       <td>{{$c->credit}}</td>
                       <td>
                           @if($c->c_status=='已结课')
                           已结课
                           @elseif($c->c_date<$date)
                           正在授课
                           @else
                           待开课
                           @endif
                       </td>
                       <td class="td-manage">
                         <input class="layui-btn layui-btn-primary" type="button" onclick="c_cj(this,{{ $c->c_id}})" value="查看成绩" />
                       </td>
                     </tr>
                     @endforeach
                     </tbody>
</TABLE>
<div align="center">
    {!! $course->appends($request->all())->render() !!}
</div>
</body>
<script>
 function c_cj(obj,id){
            $.get('course/studentList/'+id,function(data){

                    window.location.href = "/admin/course/studentList/"+id;

            })


    };
</script>
</html>

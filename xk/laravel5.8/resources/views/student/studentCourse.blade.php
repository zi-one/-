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
    <form method="get" action="{{ url('student/studentCourse') }}">
        <select name="c_status" style="width:150px;height: 25px;">
            <option selected disabled="disabled">
                @if($request->input('c_status')=='')
                课程状态:
                @elseif($request->input('c_status')=='已结课')
                课程状态:已结课
                @elseif($request->input('c_status')=='选课已结束')
                课程状态:已开课
                @endif
                </option>
            <option value="选课已结束">已开课</option>
            <option value="已结课">已结课</option>
        </select>
    <input type="text" name="username" value="{{$request->input('username')}}"  placeholder="请输入课程名">
    <button type="submit"><i class="fa fa-search"></i></button>
    <a href="{{url('student/studentCourse')}}" style="float: right;font-size: 25px;margin: 0px 50px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
    </form>
     </div>

<TABLE border=1 cellspacing=0 bordercolor="#CCC" style=" width: 100%;"  class="layui-table">
   <thead>
             <tr>
               <th>ID</th>
               <th>课程名</th>
               <th>课程老师</th>
               <th>学分</th>
               <th>课程状态</th>
               <th>成绩</th></tr>
           </thead>
            <tbody>
                @foreach($studentCourse as $sc)
                     <tr>
                       <td>{{$sc->sc_id}}</td>
                       <td>{{$sc->c_name}}</td>
                       <td>{{$sc->t_name}}</td>
                       <td>{{$sc->credit}}</td>
                       <td>
                           @if($sc->c_status=='选课已结束')
                           课程已开始
                           @elseif($sc->c_status=='已结课')
                           课程已结束
                           @endif
                       </td>
                       <td>
                           @if($sc->c_cj=='' || $sc->c_status!='已结课')
                           成绩未发布
                           @elseif($sc->c_cj!='' && $sc->c_status=='已结课')
                           {{$sc->c_cj}}
                           @endif
                       </td>
                     </tr>
                     @endforeach
                     </tbody>
</TABLE>
<div align="center">
    {!! $studentCourse->appends($request->all())->render() !!}
</div>
</body>
</html>

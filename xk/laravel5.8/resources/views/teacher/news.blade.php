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
               <th>消息内容</th>
               </tr>
           </thead>
            <tbody>
                @foreach($news as $n)
                     <tr height="50px">
                       <td>{{$n->c_name}}</td>
                       <td>您教的课程由于人数不足,无法开课!</td>
                     </tr>
                     @endforeach
           </tbody>
</TABLE>
</body>
</html>

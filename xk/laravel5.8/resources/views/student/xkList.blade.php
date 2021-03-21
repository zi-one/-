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
    <form method="get" action="{{ url('student/xkList') }}">
        <select name="c_type" style="width:180px;height: 25px;">
            <option selected disabled="disabled">课程类型:{{$request->input('c_type')}}</option>
            <option value="人文社科类">人文社科类</option>
            <option value="创新创业类">创新创业类</option>
            <option value="交通行业类">交通行业类</option>
            <option value="自然科学与工程技术类">自然科学与工程技术类</option>
        </select>
    <input type="text" name="username" value="{{$request->input('username')}}"  placeholder="请输入课程名或老师名">
    <button type="submit"><i class="fa fa-search"></i></button>
    <a href="{{url('student/xkList')}}" style="float: right;font-size: 25px;margin: 0px 50px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
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
               <th>操作</th></tr>
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
                          @if($c->c_status=='已满人')
                          已满人
                          @elseif($c->c_status=='选课已结束' || $c->c_status=='已结课')
                          已结束选课
                          @else
                          已开始选课
                          @endif
                       </td>
                       <td class="td-manage">
                           @if($c->c_status=='已满人' || $c->c_status=='选课已结束' ||$c->c_status=='已结课')
                         <input class="layui-btn layui-btn-disabled" disabled type="button" onclick="c_select(this,{{ $c->c_id}})" value="选择" />
                           @else
                           <input class="layui-btn layui-btn-primary" type="button" onclick="c_select(this,{{ $c->c_id}})" value="选择" />
                          @endif
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

 function c_select(obj,id){
     layui.use('layer', function(){
         var layer = layui.layer
         layer.confirm('你确定要选择该课程吗?', {icon: 3, title:'提示'}, function(index){
            $.post('courseSelect/'+id,{"_token":"{{csrf_token()}}"},function(data){
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
         })

     });

    };


</script>
</html>

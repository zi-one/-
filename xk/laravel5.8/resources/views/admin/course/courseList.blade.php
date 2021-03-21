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
    <form method="get" action="{{ url('admin/course') }}">
    <a class="btn btn-danger" href="#" onclick="delAll()">
      <i class="fa fa-trash-o fa-lg"></i> 批量删除</a>
    <a class="btn btn-success" href="{{url('admin/course/create')}}">
      <i class="fa fa-plus-circle"></i>添加</a>
    <input type="text" name="username" value="{{$request->input('username')}}"  placeholder="请输入课程名">
    <button type="submit"><i class="fa fa-search"></i></button>
    <a href="{{url('admin/course')}}" style="float: right;font-size: 25px;margin: 0px 50px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
    </form>
     </div>

<TABLE border=1 cellspacing=0 bordercolor="#CCC" style=" width: 100%;" class="layui-table">
   <thead>
             <tr>
               <th>
                 <div><i class="layui-icon"></i></div>
               </th>
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
                       <td align="center">
                         <input type="checkbox" name="del_checkbox" data-id="{{$c->c_id}}" />
                       </td>
                       <td>{{$c->c_id}}</td>
                       <td>{{$c->c_name}}</td>
                       <td>{{$c->t_name}}</td>
                       <td>{{$c->c_type}}</td>
                       <td>{{$c->c_select}}</td>
                       <td>{{$c->c_limit}}</td>
                       <td>{{$c->c_date}}</td>
                       <td>{{$c->credit}}</td>
                       <td>
                           @if($c->c_status=='未发布')
                           未发布
                           @elseif($c->c_status=='选课已结束')
                           课程已开始
                           @elseif($c->c_status=='已发布')
                           已发布
                           @elseif($c->c_status=='已满人')
                           已满人
                           @else
                           已结课
                           @endif
                       </td>
                       <td class="td-manage">
                           @if($c->c_status=='未发布')
                           <input type="button" onclick="add_c(this,{{$c->c_id}})" value="发布课程" />
                           @else
                           @endif
                         <a title="编辑" href="{{url('admin/course/'.$c->c_id.'/edit')}}">
                           <i class="fa fa-pencil-square-o"></i>
                         </a>
                         <a title="删除" onclick="c_del(this,{{ $c->c_id}})" href="javascript:;">
                           <i class="fa fa-trash-o"></i>
                         </a>
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
    function c_del(obj,id){
        layui.use('layer', function(){
            var layer = layui.layer
            layer.confirm('确定要删除吗?', {icon: 3, title:'提示'}, function(index){
            $.post('/admin/course/'+id,{"_method":"delete","_token":"{{csrf_token()}}"},function(data){
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

            layer.close(index);
        });
        })
    };

    function delAll(){
        var ids=[];
        $('input[name="del_checkbox"]:checked').each(function(i,v){
           var u=$(v).attr('data-id');
           ids.push(u);
     })
        layui.use('layer', function(){
            var layer = layui.layer
            layer.confirm('确定要删除吗?', {icon: 3, title:'提示'}, function(index){
           $.post('/admin/student/del',{"ids":ids,"_token":"{{csrf_token()}}"},function(data){
               if(data.status==0){
                   $('input[name="del_checkbox"]:checked').parents("tr").remove();
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
        })
    };




    function add_c(obj,id){
        layui.use('layer', function(){
            var layer = layui.layer
            layer.confirm('确定要发布吗?', {icon: 3, title:'提示'}, function(index){
                $.post('/admin/course/submit_c/'+id,{"_token":"{{csrf_token()}}"},function(data){
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
        })
    };
</script>
</html>

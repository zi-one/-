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
    <form method="get" action="{{ url('admin/student') }}">
    <a class="btn btn-danger" href="#" onclick="delAll()">
      <i class="fa fa-trash-o fa-lg"></i> 批量删除</a>
    <a class="btn btn-success" href="{{url('admin/student/create')}}">
      <i class="fa fa-plus-circle"></i>添加</a>
    <input type="text" name="username" value="{{$request->input('username')}}"  placeholder="请输入用户名">
    <button type="submit"><i class="fa fa-search"></i></button>
    <a href="{{url('admin/student')}}" style="float: right;font-size: 25px;margin: 0px 50px;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
    </form>
     </div>

<TABLE border=1 cellspacing=0 bordercolor="#CCC" style=" width: 100%;" class="layui-table">
   <thead>
             <tr>
               <th>
                 <div><i class="layui-icon"></i></div>
               </th>
               <th>ID</th>
               <th>姓名</th>
               <th>性别</th>
               <th>学号</th>
               <th>手机</th>
               <th>学院</th>
               <th>班级</th>
               <th>操作</th></tr>
           </thead>
            <tbody>
                @foreach($student as $s)
                     <tr>
                       <td align="center">
                         <input type="checkbox" name="del_checkbox" data-id="{{$s->s_id}}" />
                       </td>
                       <td>{{$s->s_id}}</td>
                       <td>{{$s->s_name}}</td>
                       <td>{{$s->s_gender}}</td>
                       <td>{{$s->s_number}}</td>
                       <td>{{$s->s_phone}}</td>
                       <td>{{$s->s_college}}</td>
                       <td>{{$s->s_class}}</td>


                       <td class="td-manage">
                         <a title="编辑" href="{{url('admin/student/'.$s->s_id.'/edit')}}">
                           <i class="fa fa-pencil-square-o"></i>
                         </a>
                         <a title="删除" onclick="s_del(this,{{ $s->s_id}})" href="javascript:;">
                           <i class="fa fa-trash-o"></i>
                         </a>
                       </td>
                     </tr>
                     @endforeach
                     </tbody>
</TABLE>
<div align="center">
    {!! $student->appends($request->all())->render() !!}
</div>
</body>
<script>
    function s_del(obj,id){
        var r=confirm("你确定要删除吗?");
        if (r==true){
            $.post('/admin/student/'+id,{"_method":"delete","_token":"{{csrf_token()}}"},function(data){
                if(data.status==0){
                    $(obj).parents("tr").remove();
                    alert(data.message);
                }else{
                    alert(data.message);
                }
            })
          }

    };

    function delAll(){
        var ids=[];
        $('input[name="del_checkbox"]:checked').each(function(i,v){
           var u=$(v).attr('data-id');
           ids.push(u);
     })
       var r=confirm("你确定要删除吗?");
       if (r==true){
           $.post('/admin/student/del',{"ids":ids,"_token":"{{csrf_token()}}"},function(data){
               if(data.status==0){
                   $('input[name="del_checkbox"]:checked').parents("tr").remove();
                   alert(data.message);
                   // console.log(data.message);
               }else{
                   alert(data.message);
                   // console.log(data.message);
               }
           })
           // $.ajax({
           //     type:'post',
           //     url:'/admin/student/del',
           //     dataType:'json',
           //     headers:{
           //         'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
           //     },
           //     data:{ ids:ids},
           //     success:function(data){
           //         if(data.status==0){
           //             $('input[name="del_checkbox"]:checked').parents("tr").remove();
           //             alert(data.message);
           //         }else if(data.status==1){
           //         alert(data.message);
           //     }
           //     },
           // })
         }
    };



 $("select").change(function(){
 			 var id=$(this).attr("dataid");
 			 var power=$(this).val();
 			 var is_change=confirm("你确定要修改吗?");
 			 if(is_change){
 			 $.post('/admin/student/change_p',{"id":id,"power":power,"_token":"{{csrf_token()}}"},function(data){
 			     if(data.status==0){
 			         alert(data.message);
 			     }else{
 			         alert(data.message);
 			     }
 			 })
 }
 });

</script>
</html>

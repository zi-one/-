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
    <form method="get" action="{{ url('admin/course/studentList/'.$id) }}">
    <input type="text" name="username" value="{{$request->input('username')}}"  placeholder="请输入学生名">
    <button type="submit"><i class="fa fa-search"></i></button>
    </form>
     </div>
<form action="">
<div style="width: 500px;position: absolute;top: 25px;left: 350px;">
<input type="submit" onclick="save_cj()" value="保 存 " />
<input type="submit" onclick="submit_cj()" value="提 交 " />

</div>

<TABLE border=1 cellspacing=0 bordercolor="#CCC" style=" width: 100%;" class="layui-table">
   <thead>
             <tr>
               <th>学生</th>
               <th>班级</th>
               <th>成绩</th>
               </tr>
           </thead>
            <tbody>

                @foreach($student as $s)
                     <tr>
                       <td>{{$s->s_name}}</td>
                       <td>{{$s->s_class}}</td>
                       <td>
                           @if($s->edit_status==3)
                           <input type="text" name="s_cj" cj-id="{{$s->sc_id}}" value="{{$s->c_tempCj}}"/>
                           @else
                           <input type="text" name="s_cj" cj-id="{{$s->sc_id}}" value="{{$s->c_cj}}"/>
                           @endif
                       </td>

                     </tr>
                     @endforeach
                     </tbody>
</TABLE>
</form>
<div align="center">
    {!! $student->appends($request->all())->render() !!}
</div>
</body>
<script>


 function submit_cj(){
     var ids=[];
     var cj=[];
     $('input[name="s_cj"]').each(function(i,v){
         if($(this).val()!=''){
             var u=$(v).attr('cj-id');
             ids.push(u);

             var c=$(v).val();
             cj.push(c);
         }
  })

    var r=confirm("你确定要提交吗?");
    if (r==true){
        $.post('/admin/submitCj',{"ids":ids,"cj":cj,"_token":"{{csrf_token()}}"},function(data){
            if(data.status==0){
                alert(data.message);
            }else{
                alert(data.message);
            }
        })

      }
 };

  function save_cj(){
        var ids=[];
        var cj=[];
        $('input[name="s_cj"]').each(function(i,v){
            if($(this).val()!=''){
                var u=$(v).attr('cj-id');
                ids.push(u);

                var c=$(v).val();
                cj.push(c);
            }
     })


           $.post('/admin/saveCj',{"ids":ids,"cj":cj,"_token":"{{csrf_token()}}"},function(data){
               if(data.status==0){
                   alert(data.message);
               }else{
                   alert(data.message);
               }
           })

 };


</script>
</html>

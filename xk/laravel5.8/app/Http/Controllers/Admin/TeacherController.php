<?php

namespace App\Http\Controllers\Admin;
use App\model\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *获取用户列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $teacher=Teacher::orderBy('t_id','asc')
                ->where(function($query) use($request){
                    $username=$request->input("username");
                    if(!empty($username)){
                        $query->where('t_name','like','%'.$username.'%');
                    }
                })
                ->paginate(10);

        return view('admin.teacher.teacherList',compact('teacher','request'));
    }

    /**
     * Show the form for creating a new resource.
     *返回用户添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.teacher.addTeacher');
    }

    /**
     * Store a newly created resource in storage.
     *执行添加操作
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //
        $input=$request->all();
        $username=$input['username'];
        $gender=$input['gender'];
        $phone=$input['phone'];
        $college=$input['college'];

        $password=Crypt::encrypt($input['password']);

        //判断用户名是否存在
        $user=Teacher::where('t_name',$username)->first();
        if($user){
            $data=[
                'status'=>3,
                'message'=>'用户名已存在!'
            ];

        }else if($username!=''&&$gender!=''&&$phone!=''&&$college!=''&& $password!=''){
            //用户不存在添加数据
            $res=Teacher::create(['t_name'=>$username,'t_pw'=>$password,'t_gender'=>$gender,
                                  't_phone'=>$phone,'t_college'=>$college,'t_power'=>1]);
            if($res){
                $data=[
                    'status'=>0,
                    'message'=>'添加成功'
                ];
            }else{
                $data=[
                    'status'=>1,
                    'message'=>'添加失败'
                ];
            }
            }else{
            $data=[
                'status'=>2,
                'message'=>'不能有空值哦!!!'
            ];
        }

          return $data;

    }

    /**
     * Display the specified resource.
     *学生一条用户操作
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *返回修改页面
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $teacher=Teacher::find($id);
        $password=Crypt::decrypt($teacher->t_pw);
        return view("admin.teacher.editTeacher",compact('teacher','password'));
    }

    /**
     * Update the specified resource in storage.
     *执行修改操作
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $teacher=Teacher::find($id);
        $username=$request->input('username');
        $password=Crypt::encrypt($request->input('password'));
        $gender=$request->input('gender');
        $phone=$request->input('phone');
        $college=$request->input('college');

        $teacher->t_name=$username;
        $teacher->t_pw=$password;
        $teacher->t_gender=$gender;
        $teacher->t_phone=$phone;
        $teacher->t_college=$college;
        $res=$teacher->save();
        if($res){
            $data=[
                'status'=>0,
                'message'=>'修改成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'修改失败'
            ];
        }
          return $data;
    }

    /**
     * Remove the specified resource from storage.
     *执行删除操作
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $teacher=Teacher::find($id);
        $res=$teacher->delete();
        if($res){
            $data=[
                'status'=>0,
                'message'=>'删除成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'删除失败'
            ];
        }
        return $data;
    }

    //删除选中的用户
    public function delAll(Request $request){
        $input=$request->input('ids');
        $res=Teacher::destroy($input);
        if($res){
            $data=[
                'status'=>0,
                'message'=>'删除成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'删除失败'
            ];
        }
        return $data;
    }

    //修改权限
    public function change_p(Request $request){
        $input=$request->except("_token");
        // dd($input);
        $id=$input['id'];
        $power=$input['power'];
        $Teacher=Teacher::find($id);
        $Teacher->s_power=$power;
        $res=$Teacher->save();
        if($res){
            $data=[
                'status'=>0,
                'message'=>'修改成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'修改失败'
            ];
        }
        return $data;
    }
}

<?php

namespace App\Http\Controllers\Admin;
use App\model\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *获取用户列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $student=Student::orderBy('s_id','asc')
                ->where(function($query) use($request){
                    $username=$request->input("username");
                    if(!empty($username)){
                        $query->where('s_name','like','%'.$username.'%');
                    }
                })
                ->paginate(10);

        return view('admin.student.studentList',compact('student','request'));
    }

    /**
     * Show the form for creating a new resource.
     *返回用户添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.student.addStudent');
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
        $number=$input['number'];
        $phone=$input['phone'];
        $college=$input['college'];
        $class=$input['s_class'];

        $password=Crypt::encrypt($input['password']);

        //判断用户名是否存在
        $user=Student::where('s_name',$username)->first();
        if($user){
            $data=[
                'status'=>3,
                'message'=>'用户名已存在!'
            ];

        }else if($username!=''&&$gender!=''&&$number!=''&&$phone!=''&&$college!=''&&$class!=''){
            //用户不存在添加数据
            $res=Student::create(['s_name'=>$username,'s_pw'=>$password,'s_gender'=>$gender,'s_number'=>$number,
                                  's_phone'=>$phone,'s_college'=>$college,'s_class'=>$class,'s_power'=>1]);
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
        $student=Student::find($id);
        return view("admin.student.editStudent",compact('student'));
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
        $student=Student::find($id);
        $username=$request->input('username');
        $password=Crypt::encrypt($request->input('password'));
        $gender=$request->input('gender');
        $number=$request->input('number');
        $phone=$request->input('phone');
        $college=$request->input('college');
        $class=$request->input('s_class');

        $student->s_name=$username;
        $student->s_pw=$password;
        $student->s_gender=$gender;
        $student->s_number=$number;
        $student->s_phone=$phone;
        $student->s_college=$college;
        $student->s_class=$class;
        $res=$student->save();
        if($res){
            $data=[
                'status'=>0,
                'message'=>'修改成功'
            ];
            // return view("admin.studentList");
        }else{
            $data=[
                'status'=>1,
                'message'=>'修改失败'
            ];
            // return back()->with('msg',"修改失败!");
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
        $student=Student::find($id);
        $res=$student->delete();
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
        $res=Student::destroy($input);
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
        $Student=Student::find($id);
        $Student->s_power=$power;
        $res=$Student->save();
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

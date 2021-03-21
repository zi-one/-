<?php

namespace App\Http\Controllers\Admin;
use App\model\Course;
use App\model\studentCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *获取用户列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $course=Course::orderBy('c_id','asc')
                ->where(function($query) use($request){
                    $username=$request->input("username");
                    if(!empty($username)){
                        $query->where('c_name','like','%'.$username.'%');
                    }
                })
                ->paginate(10);

        return view('admin.course.courseList',compact('course','request'));
    }

    /**
     * Show the form for creating a new resource.
     *返回用户添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.course.addCourse');
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
        $cname=$input['cname'];
        $tname=$input['tname'];
        $ctype=$input['ctype'];
        $climit=$input['climit'];
        $cdate=$input['cdate'];
        $credit=$input['credit'];

        $user=Course::where('c_name',$cname)->first();
        if($user){
            $data=[
                'status'=>3,
                'message'=>'课程已存在!'
            ];

        }else if($cname!=''&&$tname!=''&&$ctype!=''&&$climit!=''&&$cdate!=''&&$credit!=''){
            //用户不存在添加数据
            $res=Course::create(['c_name'=>$cname,'t_name'=>$tname,'c_type'=>$ctype,'c_limit'=>$climit,'c_select'=>0,'c_date'=>$cdate,'credit'=>$credit,'c_status'=>'未发布']);
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
        $course=Course::find($id);
        return view("admin.course.editCourse",compact('course'));
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
        $course=Course::find($id);
        $cname=$request->input('cname');
        $tname=$request->input('tname');
        $ctype=$request->input('ctype');
        $climit=$request->input('climit');
        $cdate=$request->input('cdate');
        $credit=$request->input('credit');


        $course->c_name=$cname;
        $course->t_name=$tname;
        $course->c_type=$ctype;
        $course->c_limit=$climit;
        $course->c_date=$cdate;
        $course->credit=$credit;
        $res=$course->save();
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
        $course=Course::find($id);
        $res=$course->delete();
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
        $res=Course::destroy($input);
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

    //发布课程
    public function submit_c(Request $request,$id){

        $Course=Course::find($id);
        $Course->c_status='已发布';
        $res=$Course->save();

//        $studentCourse=studentCourse::where('c_id',$id)->paginate();
//        if($studentCourse){
//            foreach($studentCourse as $s){
//                $s->c_status=$Course->c_status;
//                $s->save();
//            }
//
//        }

        if($res){
            $data=[
                'status'=>0,
                'message'=>'发布成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'发布失败'
            ];
        }
        return $data;
    }

    public function courseCj(Request $request)
    {
        $time = time();
        $date = date('Y-m-d H:i:s', time());
        $course=Course::orderBy('c_id','asc')
                ->where('c_select','>',5)
                ->where(function($query) use($request){
                    $username=$request->input("username");
                    if(!empty($username)){
                        $query->where('c_name','like','%'.$username.'%');
                    }
                })
                ->paginate(10);
        return view('admin.course.courseCj',compact('course','date','request'));
    }

    //课程学生列表页面路由
    public function studentList(Request $request,$id){
        $student=studentCourse::orderBy('sc_id','asc')
                  ->where('c_id',$id)
                  ->where(function($query) use($request){
                      $username=$request->input("username");
                      if(!empty($username)){
                          $query->where('s_name','like','%'.$username.'%');
                      }
                  })
                  ->paginate(10);
          return view('admin.course.studentList',compact('student','request','id'));

    }

    //保存成绩
    public function saveCj(Request $request){
        $ids=$request->input('ids');
        $cj=$request->input('cj');


        foreach($ids as $i=>$c){
                $studentCourse=studentCourse::find($c);
                $studentCourse->c_tempCj=$cj[$i];
                $studentCourse->edit_status=3;

                $res=$studentCourse->save();
        }


         if($res){
             $data=[
                 'status'=>0,
                 'message'=>'保存成功'
             ];
         }else{
             $data=[
                 'status'=>1,
                 'message'=>'保存失败'
             ];
         }
         return $data;

    }

    //提交成绩
    public function submitCj(Request $request){
        $ids=$request->input('ids');
        $cj=$request->input('cj');


        foreach($ids as $i=>$c){
                $studentCourse=studentCourse::find($c);
                $studentCourse->c_cj=$cj[$i];
                $studentCourse->edit_status=1;

                $res=$studentCourse->save();
        }


         if($res){
             $data=[
                 'status'=>0,
                 'message'=>'提交成功'
             ];
         }else{
             $data=[
                 'status'=>1,
                 'message'=>'提交失败'
             ];
         }
         return $data;

    }


}

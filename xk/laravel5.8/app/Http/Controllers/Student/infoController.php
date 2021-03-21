<?php

namespace App\Http\Controllers\Student;
use App\model\Student;
use App\model\Course;
use App\model\studentCourse;
use App\model\teacherCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
class infoController extends Controller
{
    //
    public function index(){
             return view("student.index");
         }

    //退出登录
      public function logout(){
          session()->flush();
             return redirect("login");
         }
         //修改密码
         public function editPass(Request $request){
                 if($input=$request->all()){
                     $rules=[
                         "password"=>"required|between:3,12|confirmed",
                     ];
                     $message=[
                         "password.required"=>"密码不能为空!",
                         "password.between"=>"密码必须为3-12位!",
                         "password.confirmed"=>"两次输入密码不一致!"
                     ];

                     $validator=Validator::make($input,$rules,$message);
                     if($validator->passes()){
                         $old_pw=Student::where('s_name',session('user'))->value('s_pw');
                         if(Crypt::decrypt($old_pw)==$input['password_o']){
                             //根据's_name'='user' 查询id 更新密码
                             Student::where('s_name',session('user'))->update(['s_pw'=>Crypt::encrypt($input['password'])]);
                             return back()->with('msg',"新密码设置成功");
                         }else{
                             return back()->with('msg',"原密码错误!");
                         }
                     }else{
                         return back()->withErrors($validator);
                     }
                 }else{
                     //返回视图
                     return view("student.editPass");
                 }

             }

       //选课列表
      public function xkList(Request $request)
      {

          $course=Course::orderBy('c_id','asc')
                  ->where('c_status','<>','未发布')
                  ->where(function($query) use($request){
                      $username=$request->input("username");
                      if(!empty($username)){
                          $query->where('c_name','like','%'.$username.'%')->orwhere('t_name','like','%'.$username.'%');
                      }
                      $c_type=$request->input("c_type");
                          $query->where('c_type','like','%'.$c_type.'%');
                  })
                  ->paginate(10);

            foreach($course as $c){
            if($c->c_select==$c->c_limit){
                $c->c_status='已满人';
                $c->save();
            }
            }

            foreach($course as $c){
             $time = time();
             $date = date('Y-m-d H:i:s', time());
            if($c->c_date<$date && $c->c_status!='已结课'){
            //     $c->c_status=1;
            //     $c->save();
            // }else{
                $c->c_status='选课已结束';
                $c->save();

                $studentCourse=studentCourse::where('c_id',$c->c_id)->first();
                if($studentCourse){
                    $studentCourse->c_status=$c->c_status;
                    $studentCourse->c_select=$c->c_select;
                    $studentCourse->save();
                }

            }
            }

          return view('student.xkList',compact('course','request'));
      }


      //选择课程
      public function courseSelect(Request $request,$id){
         $course=Course::find($id);
         $cid=$course['c_id'];
         $cname=$course['c_name'];
         $tname=$course['t_name'];
         $credit=$course['credit'];
         $status=$course['c_status'];
         $ctype=$course['c_type'];
         $cselect=$course['c_select'];
         $climit=$course['c_limit'];

         $student=Student::where('s_name',session('user'))->first();
         $sclass=$student->s_class;

         $c_name=studentCourse::where('c_name',$cname)->where('s_name',session('user'))->first();
         if($status=='已发布'  && !$c_name && $cselect<$climit){

          if($cselect==$climit-1){
              $status='已满人';
          }

             $res=studentCourse::create(['c_id'=>$cid,'c_name'=>$cname,'t_name'=>$tname,'s_class'=>$sclass,'credit'=>$credit,
                                          'c_status'=>$status,'s_name'=>session('user'),'c_type'=>$ctype,'c_select'=>$cselect,'edit_status'=>0]);

             if($res){
                 $course->c_select=$cselect+1;
                 $course->save();

                 $studentCourse=studentCourse::where('c_id',$id)->paginate();
                 if($studentCourse){
                     foreach($studentCourse as $sc){
                         $sc->c_select=$course->c_select;
                         $sc->c_status=$status;
                         $sc->save();
                     }
                 }


//                 $user=teacherCourse::find($cid);
//                 if(!$user){
//                     teacherCourse::create(['tc_id'=>$cid,'c_id'=>$cid,'c_name'=>$cname,'t_name'=>$tname,'s_class'=>$sclass,'credit'=>$credit,
//                                                  'c_status'=>$status,'c_type'=>$ctype,'c_select'=>$course->c_select]);
//
//                 }else{
//                     $user->c_select=$course->c_select;
//                     $user->save();
//                 }



                 $data=[
                     'status'=>0,
                     'message'=>'选课成功'
                 ];
             }else{
                 $data=[
                     'status'=>1,
                     'message'=>'选课失败'
                 ];
             }
         }else if($course->c_status=='已满人'){
             $data=[
                 'status'=>2,
                 'message'=>'课程已满人!'
             ];
         }else{
             $data=[
                 'status'=>3,
                 'message'=>'课程已停止选课!或已选择过该课程!'
             ];
         }


         return $data;
          }

    //学生已选课程页面
          public function selectedCourse(Request $request){
             $selectedCourse=studentCourse::orderBy('sc_id','asc')
                     ->where('s_name',session('user'))
                     ->whereIn('c_status',['待开课','已满人','已发布'])
                     ->where(function($query) use($request){
                         $username=$request->input("username");
                         if(!empty($username)){
                             $query->where('c_name','like','%'.$username.'%');
                         }
                     })
                     ->paginate(10);
             return view('student.selectedCourse',compact('selectedCourse','request'));
          }

//删除课程
    public function courseDel($id)
    {
        //
        $course=Course::find($id);
        $cselect=$course['c_select'];

        $studentCourse=studentCourse::where('c_id',$id)->where('s_name',session('user'));
        $res=$studentCourse->delete();
//        $teacherCourse=teacherCourse::find($id);
//        $teacherCourse->c_select=$teacherCourse->c_select-1;
//        $teacherCourse->save();
        if($res){
            $course->c_select=$cselect-1;
            $course->save();
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


    //学生课程页面
          public function studentCourse(Request $request){
             $studentCourse=studentCourse::orderBy('sc_id','asc')
                     ->where('s_name',session('user'))
                     ->whereIn('c_status',['选课已结束','已结课'])
                     ->where('c_select','>',5)
                     ->where(function($query) use($request){
                         $username=$request->input("username");
                         if(!empty($username)){
                             $query->where('c_name','like','%'.$username.'%');
                         }

                         $c_status=$request->input("c_status");
                         if($c_status!=''){
                             $query->where('c_status',$c_status);
                         }
                     })
                     ->paginate(10);

             return view('student.studentCourse',compact('studentCourse','request'));
          }



        //个人中心
            public function person(Request $request)
            {
                //
                $student=Student::where('s_name',session('user'))->first();

                return view('student.person',compact('student'));
            }
     //个人中心修改
         public function editperson(Request $request)
         {
             //
            $student=Student::where('s_name',session('user'))->first();
            $username=$request->input('username');
            $gender=$request->input('gender');
            $number=$request->input('number');
            $phone=$request->input('phone');
            $college=$request->input('college');
            $class=$request->input('s_class');

            $student->s_name=$username;
            $student->s_gender=$gender;
            $student->s_number=$number;
            $student->s_phone=$phone;
            $student->s_college=$college;
            $student->s_class=$class;
            $res=$student->save();
            if($res){
                session(['user'=>$username]);
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

         //消息
                public function news()
                {
                    //

                    $c_news=Course::orderBy('c_id','asc')->paginate(10);

                    $news=array();
                    foreach($c_news as $c){
                    if($c->c_status=='选课已结束' && $c->c_select<=5){
                        array_push($news, $c);
                    }
                    }

                    return view("student.news",compact('news'));
                }
}

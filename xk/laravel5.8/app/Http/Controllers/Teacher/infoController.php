<?php

namespace App\Http\Controllers\Teacher;
use App\model\Teacher;
use App\model\Student;
use App\model\Course;
use App\model\studentCourse;
use App\model\teacherCourse;
use App\model\applyCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
class infoController extends Controller
{
    //
    public function index(){
             return view("teacher.index");
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
                         $old_pw=Teacher::where('t_name',session('user'))->value('t_pw');
                         if(Crypt::decrypt($old_pw)==$input['password_o']){
                             Teacher::where('t_name',session('user'))->update(['t_pw'=>Crypt::encrypt($input['password'])]);
                             return back()->with('msg',"新密码设置成功");
                         }else{
                             return back()->with('msg',"原密码错误!");
                         }
                     }else{
                         return back()->withErrors($validator);
                     }
                 }else{
                     return view("teacher.editPass");
                 }

             }

       //个人中心
              public function person(Request $request)
              {
                  //
                  $teacher=Teacher::where('t_name',session('user'))->first();

                  return view('teacher.person',compact('teacher'));
              }
       //个人中心修改
           public function editperson(Request $request)
           {
               //
              $teacher=Teacher::where('t_name',session('user'))->first();
              $username=$request->input('username');
              $gender=$request->input('gender');
              $phone=$request->input('phone');
              $college=$request->input('college');


              $teacher->t_name=$username;
              $teacher->t_gender=$gender;
              $teacher->t_phone=$phone;
              $teacher->t_college=$college;
              $res=$teacher->save();
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



        //教师课程页面
                  public function teacherCourse(Request $request){
                     $teacherCourse=studentCourse::orderBy('sc_id','asc')
                             ->where('t_name',session('user'))
                             ->where(function($query) use($request){
                                 $username=$request->input("username");
                                 if(!empty($username)){
                                     $query->where('c_name','like','%'.$username.'%');
                                 }
                             })
                             ->paginate(10);
                     return view('teacher.teacherCourse',compact('teacherCourse','request'));
                  }


        //课程学生列表页面路由
        public function studentList(Request $request,$id){
            $student=studentCourse::orderBy('sc_id','asc')
                      ->where('t_name',session('user'))
                      ->where('c_id',$id)
                      ->where(function($query) use($request){
                          $username=$request->input("username");
                          if(!empty($username)){
                              $query->where('s_name','like','%'.$username.'%');
                          }
                      })
                      ->paginate(10);

              return view('teacher.studentList',compact('student','request','id'));

        }


         //添加课程页面
         public function addC(Request $request){

               return view('teacher.addCourse');
         }

         //申请课程
       public function addCourse(Request $request){
         $input=$request->all();
         $cname=$input['cname'];
         $ctype=$input['ctype'];
         $climit=$input['climit'];
         $cdate=$input['cdate'];
         $credit=$input['credit'];

         //判断课程名是否存在
         $user=Course::where('c_name',$cname)->first();
         $user2=applyCourse::where('c_name',$cname)->first();



         if(!$user && !$user2 && $cname!='' &&$climit!=''&& $cdate!=''&&$credit!=''){
             //不存在添加数据
             $res=applyCourse::create(['c_name'=>$cname,'t_name'=>session('user'),'c_type'=>$ctype,'c_limit'=>$climit,'c_date'=>$cdate,'credit'=>$credit,'c_status'=>'申请开课','c_content'=>'申请开课','news_status'=>1]);
             if($res){
                 $data=[
                     'status'=>0,
                     'message'=>'申请课程成功，等待管理员审核!'
                 ];
             }else{
                 $data=[
                     'status'=>1,
                     'message'=>'申请失败!'
                 ];
             }
             }elseif($cname==''||$climit==''|| $cdate==''||$credit==''){
             $data=[
                 'status'=>2,
                 'message'=>'不能有空值哦!!!'
             ];
         }else{
             $data=[
                 'status'=>3,
                 'message'=>'课程已存在!或申请已提交！'
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


        //保存成绩
        public function saveCj(Request $request){
            $ids=$request->input('ids');
            $cj=$request->input('cj');


            foreach($ids as $i=>$c){
                    $studentCourse=studentCourse::find($c);
                    $studentCourse->c_cj=$cj[$i];
                    $studentCourse->edit_status=0;

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


         //申请修改成绩
         public function editCj(Request $request,$id){
            $studentCourse=studentCourse::where('c_id',$id)->first();
            $cname=$studentCourse->c_name;
//            $tname=$studentCourse->t_name;
            $status=applyCourse::where('c_name',$cname)->first();

            if(!$status){


            $res=applyCourse::create(['c_name'=>$cname,'t_name'=>session('user'),'c_content'=>'申请修改成绩','c_status'=>'申请修改成绩','news_status'=>1]);
                if($res){
                    $data=[
                        'status'=>0,
                        'message'=>'申请成功，等待管理员同意!'
                    ];
                }

            }else{
                $data=[
                    'status'=>1,
                    'message'=>'已存在申请!'
                ];
            }
             return $data;


         }


      //申请消息
             public function applynews()
             {
                 //

                 $ac_news=applyCourse::orderBy('c_id','asc')->paginate(10);

                 $news=array();
                 foreach($ac_news as $c){
                 if($c->c_status=='申请开课' ||$c->c_status=='同意' || $c->c_status=='不同意' ||$c->c_status=='申请修改成绩'){
                     array_push($news, $c);
                 }
                 }

                 return view("teacher.applynews",compact('news'));
             }

             //删除申请信息
                 public function delNews($id)
                 {
                     //
                     $applyCourse=applyCourse::find($id);

                     $res=$applyCourse->delete();
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


      //撤回申请信息
        public function delApply($id)
       {
        //
        $applyCourse=applyCourse::find($id);

        $res=$applyCourse->delete();
        if($res){
            $data=[
                'status'=>0,
                'message'=>'撤回成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'撤回失败'
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

                 return view("teacher.news",compact('news'));
             }



       //结束课程
           public function endCourse($id)
           {
               //
               $studentCourse=studentCourse::where('c_id',$id)->first();;

               $studentCourse->c_status='已结课';
               $res=$studentCourse->save();


               $Course=Course::where('c_id',$id)->first();;

               $Course->c_status='已结课';
               $res2=$Course->save();
               if($res && $res2){
                   $data=[
                       'status'=>0,
                       'message'=>'结束成功'
                   ];
               }else{
                   $data=[
                       'status'=>1,
                       'message'=>'结束失败'
                   ];
               }
               return $data;
           }
}

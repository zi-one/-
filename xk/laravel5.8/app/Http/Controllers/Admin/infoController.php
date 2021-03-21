<?php

namespace App\Http\Controllers\Admin;

use App\model\Admin;
use App\model\Student;
use App\model\Teacher;
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
            return view("admin.index");
        }

   //退出登录
     public function logout(){
         session()->flush();
            return redirect("login");
        }
   //学生列表
   public function studentList(){
            return view("admin.studentList");
        }
   //增加学生
   public function addStudent(){
            return view("admin.addStudent");
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
                   $old_pw=Admin::where('a_name',session('user'))->value('a_pw');
                   if(Crypt::decrypt($old_pw)==$input['password_o']){
                       Admin::where('a_name',session('user'))->update(['a_pw'=>Crypt::encrypt($input['password'])]);
                       return back()->with('msg',"新密码设置成功");
                   }else{
                       return back()->with('msg',"原密码错误!");
                   }
               }else{
                   return back()->withErrors($validator);
               }
           }else{
               return view("admin.editPass");
           }

       }


         //申请消息
                public function news()
                {
                    //
                    $course=applyCourse::orderBy('c_id','asc')->where('news_status','<>',0)
                    ->paginate(10);


                    return view("admin.news",compact('course'));
                }

        //课程消息
               public function courseNews()
               {
                   //

                   $c_news=Course::orderBy('c_id','asc')->paginate(10);

                   $news=array();
                   foreach($c_news as $c){
                   if($c->c_status=='选课已结束' && $c->c_select<=5){
                       array_push($news, $c);
                   }
                   }

                   return view("admin.courseNews",compact('news'));
               }

         //同意申请信息
                public function agree(Request $request,$id)
                {
                    //
                    $course=applyCourse::find($id);
                    $cname=$course->c_name;
                    $tname=$course->t_name;
                    $ctype=$course->c_type;
                    $climit=$course->c_limit;
                    $credit=$course->credit;
                    $cdate=$course->c_date;

                    if($cdate!=''){
                        $user=Course::where('c_name',$cname)->first();
                        if($user){
                            $data=[
                                'status'=>3,
                                'message'=>'课程已存在!'
                            ];

                        }else{
                            $res=Course::create(['c_id'=>$id,'c_name'=>$cname,'t_name'=>$tname,'c_type'=>$ctype,'c_limit'=>$climit,'c_select'=>0,'c_date'=>$cdate,'credit'=>$credit,'c_status'=>'未发布']);

                            if($res){
                                // $course->delete();
                                $course->c_status='同意';
                                $course->save();
                                $data=[
                                    'status'=>0,
                                    'message'=>'课程添加成功!'
                                ];
                            }else{
                                $data=[
                                    'status'=>1,
                                    'message'=>'课程添加失败!'
                                ];
                            }
                            }
                    }else{
                        $studentCourse=studentCourse::select()->paginate();
                        foreach($studentCourse as $sc){
                            $sc->edit_status=0;
                            $sc->save();
                        }
                        // $course->delete();
                        $course->c_status='同意';
                        $course->save();
                        $data=[
                            'status'=>4,
                            'message'=>'同意申请成功!'
                        ];

                    }


                      return $data;

                }


    //拒绝申请信息
    public function disagree(Request $request,$id)
    {
        //
            $course=applyCourse::find($id);

            $course->c_status='不同意';
            $res=$course->save();
            if($res){
                $data=[
                    'status'=>0,
                    'message'=>'拒绝申请成功!'
                ];
            }

        return $data;

    }


        //删除课程
            public function delCourse($id)
            {
                //
                $course=Course::find($id);
                $res=$course->delete();
                $studentCourse=studentCourse::where('c_id',$id);
                if($studentCourse){
                   $studentCourse->delete();
                }

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

            //删除信息
                public function delNews($id)
                {
                    //
                    $applyCourse=applyCourse::find($id);
                    $applyCourse->news_status=0;
                    $res=$applyCourse->save();
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

       //个人中心
              public function person(Request $request)
              {
                  //
                  $admin=Admin::where('a_name',session('user'))->first();

                  return view('admin.person',compact('admin'));
              }
       //个人中心修改
           public function editperson(Request $request)
           {
               //
              $admin=Admin::where('a_name',session('user'))->first();
              $username=$request->input('username');
              $gender=$request->input('gender');
              $phone=$request->input('phone');

              $admin->a_name=$username;
              $admin->a_gender=$gender;
              $admin->a_phone=$phone;

              $res=$admin->save();
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

    function jiami(){
        $str='123456';
        $crypt_str=Crypt::encrypt($str);
        return $crypt_str;
    }


}

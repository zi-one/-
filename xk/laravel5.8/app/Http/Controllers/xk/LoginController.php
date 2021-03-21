<?php

namespace App\Http\Controllers\xk;
use App\model\Admin;
use App\model\Student;
use App\model\Teacher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
require_once "../resources/views/code/Code.class.php";
class LoginController extends Controller
{
    //
	public function login(){
		return view('login');
	}


     public function register(){
		return view('register');
	}

//登录
    public function dologin(Request $request){
	    //获取所有信息，除了token
        $input=$request->except('_token');

        $rule=[
            'username'=>'required|between:2,12',
            'password'=>'required|between:3,12',
            'code'=>'required',
        ];

        $msg=[
          'username.required'=>'用户名不能为空!',
          'username.between'=>'用户名长度必须在2到12位!',
          'password.required'=>'密码不能为空!',
          'password.between'=>'密码长度必须在3到12位!',
          'code.required'=>'验证码不能为空!',
        ];

//        匹配信息
        $validator=Validator::make($input,$rule,$msg);

//        判断错误
        if($validator->fails()){
            return redirect('login')
                  ->withErrors($validator)
                  ->withInput();
        }


        $select=$input['mySelect'];
        if($select==1){
            $user=Student::where('s_name',$input['username'])->first();
            if(!$user){
                return back()->with('msg',"用户名不存在!");
            }

            if($input['password']!=Crypt::decrypt($user->s_pw)){
                return back()->with('msg',"密码错误!");
            }

            //匹配大小写
            if(strtolower($input['code'])!=strtolower($_SESSION['code'])){
                return back()->with('msg',"验证码不正确!");
            }

            if($user->s_power==0){
                return back()->with('msg',"你的权限不足无法登录!!!");
            }
            session(['user'=>$input['username']]);
            return redirect('student/index');
        }
        if($select==2){
            $user=Teacher::where('t_name',$input['username'])->first();
            if(!$user){
                return back()->with('msg',"用户名不存在!");
            }

            if($input['password']!=Crypt::decrypt($user->t_pw)){
                return back()->with('msg',"密码错误!");
            }

            if(strtolower($input['code'])!=strtolower($_SESSION['code'])){
                return back()->with('msg',"验证码不正确!");
            }
            if($user->t_power==0){
                return back()->with('msg',"你的权限不足无法登录!!!");
            }
            session(['user'=>$input['username']]);
            return redirect('teacher/index');
        }
        if($select==3){
        $user=Admin::where('a_name',$input['username'])->first();
        if(!$user){
            return back()->with('msg',"用户名不存在!");
        }

        if($input['password']!=Crypt::decrypt($user->a_pw)){
            return back()->with('msg',"密码错误!");
        }

        if(strtolower($input['code'])!=strtolower($_SESSION['code'])){
            return back()->with('msg',"验证码不正确!");
        }

        //保存数据
        session(['user'=>$input['username']]);
        return redirect('admin/index');
        }
    }

//注册
    public function doregister(Request $request){
        $input=$request->except('_token');

        $rule=[
            'username'=>'required|between:2,12',
            'password'=>'required|between:3,12',
        ];

        $msg=[
          'username.required'=>'用户名不能为空!',
          'username.between'=>'用户名长度必须在2到12位!',
          'password.required'=>'密码不能为空!',
          'password.between'=>'密码长度必须在3到12位!',
        ];
        $validator=Validator::make($input,$rule,$msg);

        if($validator->fails()){
            return redirect('register')
                  ->withErrors($validator)
                  ->withInput();
        }


        $select=$input['mySelect'];
        if($select==1){

            $user=Student::where('s_name',$input['username'])->first();
            if($user){
                return back()->with('msg',"用户名已存在!");
            }

            $res=Student::insert(['s_name'=>$input['username'],'s_pw'=>Crypt::encrypt($input['password']),'s_power'=>1]);
            if($res){
                 echo ("<script>alert('注册成功!');location.href='../login'</script>");
            }else{
                return back()->with('msg',"注册失败!");
            }

        }
        if($select==2){

            $user=Teacher::where('t_name',$input['username'])->first();
            if($user){
                return back()->with('msg',"用户名已存在!");
            }

            $res=Teacher::insert(['t_name'=>$input['username'],'t_pw'=>Crypt::encrypt($input['password']),'t_power'=>1]);
            if($res){
                 echo ("<script>alert('注册成功!');location.href='../login'</script>");
            }else{
                return back()->with('msg',"注册失败!");
            }

        }
        if($select==3){

            $user=Admin::where('a_name',$input['username'])->first();
            if($user){
                return back()->with('msg',"用户名已存在!");
            }

            $res=Admin::insert(['a_name'=>$input['username'],'a_pw'=>Crypt::encrypt($input['password'])]);
            if($res){
                 echo ("<script>alert('注册成功!');location.href='../login'</script>");
            }else{
                return back()->with('msg',"注册失败!");
            }

        }
    }



     public function welcome(){
         return view("IndexWelcome");
     }
    //验证码
      function code(){
           $code=new \Code();
           $_code=$code->make();

       }
}

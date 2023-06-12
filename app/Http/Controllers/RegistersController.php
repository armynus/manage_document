<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validate;
use App\Models\Users;
use App\Models\Documents;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\View\Components\Alert;
use Session;
session_start();

class RegistersController extends Controller
{
    public function login_admin(){
        if(Session::get('admin_id')){
            return redirect()->route('admin_page');
        }
        return view('admin.login');
    }
    public function logins_admin(Request $request){
        
        $email= $request->email;
        $password=$request->password;
        $result= DB::table('users')
            ->where('email',$email)
            ->where('role_id',0)
            ->first();      

        if(Hash::check($password, $result->password )){
            Session:: put('admin_id',$result->id);
            Session:: put('admin_name',$result->name);
            Session:: put('admin_email',$result->email);
            return redirect()->route('admin_page');
       
        }else{
            return redirect()->route('login_admin')->with('error','Sai email hoặc mật khẩu');
        }
    }
    public function logout_admin(){
        Session::put('admin_id',null);
        Session::put('admin_name',null);
        Session::put('admin_email',null);
        return redirect()->route('login_admin');
    }
    public function admin_page(){
        $admin_id=Session::get('admin_id');
        $data_count=Documents::get()->count();
        $user_count=Users::where('status',0)->get()->count();
        $user_lock=Users::where('status',1)->get()->count();
        $noti_count=Notification::get()->count();
        return view('admin.index',compact('data_count','user_count','user_lock','noti_count'));
    }

    public function login_user(){
        if(Session::get('user_id')){
            return redirect()->route('index');
        }
        return view('user.login');
    }
    public function logins_user(Request $request){
        
        $email= $request->email;
        $password=$request->password;
        $result= DB::table('users')
            ->where('email',$email)
            ->first();      
           
        if ($result == null) {
            return redirect()->route('login_user')->with('error','Nhập sai email hoặc mật khẩu');
        }
        if($result->status == 1 ) {
            return redirect()->route('login_user')->with('error','Tài khoản đã bị khóa');
        }

        if(Hash::check($password, $result->password )){
            Session:: put('user_id',$result->id);
            Session:: put('user_name',$result->name);
            Session:: put('user_email',$result->email);
            return redirect()->route('index');
        
        }else{
            return redirect()->route('login_user')->with('error','Nhập sai email hoặc mật khẩu');
        }
    }
    public function logout_user(){
        Session::put('user_id',null);
        Session::put('user_name',null);
        Session::put('user_email',null);
        return redirect()->route('login_user');
    }
}

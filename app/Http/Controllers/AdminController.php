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
class AdminController extends Controller
{
    public function add_user(){
        
        return view('admin.add_user');
    }
    public function adds_user(Request $request){
        $data=array();
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['password']=Hash::make($request->password);
        $data['role_id']=1;
        $data['status']=0;
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        $email= Users::select('email')->get();
        foreach ($email as $key => $value) {
            if ($request->email == $value->email) {
                return redirect()->back()->with('error','Email đã tồn tại') ;
            }
        }
        Users::insert($data);
        return redirect()->back()->with('message','Thêm thành công') ;
    }
    public function list_staff(){
        $list_staff=Users::where('role_id',1)
        ->where('status',0)
        ->select('id','email','name','status','created_at','updated_at')
        ->orderBy('id','DESC')

        ->get();
        return view('admin.list_staff',compact('list_staff'));
    }
    public function list_staff_block(){
        $list_staff=Users::where('role_id',1)
        ->where('status',1)
        ->select('id','email','name','status','created_at','updated_at')
        ->orderBy('id','DESC')
        ->get();
        return view('admin.list_staff_block',compact('list_staff'));
    }
    public function lock_user(Request $request){
        $id=$request->user_id;
        $users = Users::where('id',$id)
        ->update(['status' => 1]);

        return response()->json([
            'status' => true
        ]);
    }
    public function unlock_user(Request $request){
        $id=$request->user_id;
        $users = Users::where('id',$id)
        ->update(['status' => 0]);

        return response()->json([
            'status' => true
        ]);
    }
    public function edit_user($user_id){
        $user=Users::where('id',$user_id)
        ->select('id','email','name')
        ->first();
        return view('admin.edit_user',compact('user'));
    }
    public function edits_user(Request $request){
        $id=$request->user_id;
        $email= Users::select('email')
        ->where('id', '!=', $id)
        ->get();
        
        foreach ($email as $key => $value) {
            if ($request->email == $value->email) {
                return redirect()->back()->with('error','Email đã tồn tại') ;
            }
        }
        $data=array();
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['password']=Hash::make($request->password);
        Users::where('id',$id)->update($data);
        return redirect()->back()->with('message','Cập nhật thành công') ;
    }
    public function filter_document_admin(){
        $admin_id=Session::get('admin_id');
        $years= Documents::select(DB::raw('YEAR(document_time) as year'))->distinct()->get();
        $data = DB::table('documents')
        ->join('category_document', 'documents.category_id', '=', 'category_document.id')
        ->select('documents.*', 'category_document.category_name')
        ->orderBy('documents.id','DESC')
        ->limit(200)
        ->get();
        
        $count_data = count($data);
        $categorys=DB::table('category_document')->select('id','category_name') ->get();
        
        return view('admin.filter_document_admin',compact('years','data','admin_id','count_data','categorys'));
    }
    public function view_filter_document_admin(Request $request){
        $admin_id=Session::get('admin_id');
        $year=$request->year;
        $quarter=$request->quarter;
        $category_id=$request->category_id;
        
        $data = DB::table('documents')
            ->join('category_document', 'documents.category_id', '=', 'category_document.id')
            ->select('documents.*', 'category_document.category_name')
            ->orderBy('documents.id','ASC')
            ->where('category_id', $category_id)
            ->whereYear('document_time', $year)
            ->get();
        
        $years= Documents::select(DB::raw('YEAR(document_time) as year'))->distinct()->get();
        $category=DB::table('category_document')->select('id','category_name')->where('id',$category_id) ->first();
        $categorys=DB::table('category_document')->select('id','category_name') ->get();
        // dd($category);

        $count_data = count($data);

        return view('admin.view_filter_document_admin',compact('admin_id','data','years','year','count_data','category','categorys'));
    }
    public function delete_document_admin(Request $request){
        $document_id=$request->id;
        $document=Documents::where('id',$document_id)->first();
        if ($document->document_file==null) {
            Notification::where('document_id',$document_id)->delete();
            Documents::where('id',$document_id)->delete();
            return response()->json([
                'status' => true
            ]);
        }else{
            
            $delete_file=unlink('storage/document_folder/'.$document->document_file);
            Notification::where('document_id',$request->id)->delete();
            Documents::where('id',$request->id)->delete();
            return response()->json([
                'status' => true
            ]);
        }
    }
    public function delete_detaildocument_admin(Request $request){
        $document_id=$request->id;
        $document=Documents::where('id',$document_id)->first();
        if ($document->document_file==null) {
            Notification::where('document_id',$document_id)->delete();
            Documents::where('id',$document_id)->delete();
            return response()->json([
                'status' => true
            ]);
        }else{
            
            $delete_file=unlink('storage/document_folder/'.$document->document_file);
            Notification::where('document_id',$request->id)->delete();
            Documents::where('id',$request->id)->delete();
            return response()->json([
                'status' => true
            ]);
        }
    }
    public function edit_document_admin($id){
        $admin_id=Session::get('admin_id');
        $data=Documents::where('id',$id)->first();
       
        return view('admin.edit_document_admin',compact('data','admin_id'));
    }
    public function edits_document_admin(Request $request){
        $document_id=$request->id;
        $document=Documents::where('id',$document_id)->first();
        $notifi=DB::table('notification') ->where('document_id',$document_id)->first();
        $data_notifi=array();
        $data_notifi['document_number']=$request->document_number;
        if ($notifi!=null) {
            DB::table('notification')->where('document_id',$request->id)->update($data_notifi);
        }
        if ($document->category_id==1){
            if ($document->document_file==null) {
                $data= array();
                $data['stt']=$request->stt;
                $data['department_send']=$request->department_send;
                $data['document_number']=$request->document_number;
                $data['document_time']=$request->document_time;
                $data['document_content']=$request->document_content;
                if($request->hasFile('document_file1')){
                    $save_file= $request->file('document_file1')->storeAs('public/document_folder', $request->file('document_file1')->getClientOriginalName());
                    $data['document_file']=$request->document_file1->getClientOriginalName();
                }
                $data['receiver']=$request->receiver;
                $data['updated_at']=date('Y-m-d H:i:s');
                Documents::where('id',$request->id)->update($data);
                Session::flash('document_id',$document_id);
                return redirect()->back()->with('message','Sửa thành công') ;
            }else{
                $data= array();
                $data['stt']=$request->stt;
                $data['department_send']=$request->department_send;
                $data['document_number']=$request->document_number;
                $data['document_time']=$request->document_time;
                $data['document_content']=$request->document_content;   
                if($request->hasFile('document_file1')){
                    $delete_file=unlink('storage/document_folder/'.$document->document_file);
                    $save_file= $request->file('document_file1')->storeAs('public/document_folder', $request->file('document_file1')->getClientOriginalName());
                    $data['document_file']=$request->document_file1->getClientOriginalName();
                }
                $data['receiver']=$request->receiver;
                $data['updated_at']=date('Y-m-d H:i:s');
                Documents::where('id',$request->id)->update($data);                
                Session::flash('document_id',$document_id);
                return redirect()->back()->with('message','Sửa thành công') ;
            }
        }
        if($document->document_file != null){
            $delete_file=unlink('storage/document_folder/'.$document->document_file);
        }
        $data= array();
        $data['document_number']=$request->document_number;
        $data['signer']=$request->signer;
        $data['document_time']=$request->document_time;
        $data['document_content']=$request->document_content;
        $save_file= $request->file('document_file')->storeAs('public/document_folder', $request->file('document_file')->getClientOriginalName());
        $data['document_file']=$request->document_file->getClientOriginalName();
        $data['receiver']=$request->receiver;
        $data['updated_at']=date('Y-m-d H:i:s');
        Documents::where('id',$request->id)->update($data);
        Session::flash('document_id',$document_id);
        return redirect()->back()->with('message','Sửa thành công') ;
    }
    public function view_detail_document_admin(){
        $user_id= Session::get('admin_id');

        $notification= Notification::where('user_id','!=',$user_id)
            ->orderBy('id', 'DESC')
            ->limit(10)->get();
        $html = view('admin.layouts.ajax_notifi_admin',compact('notification'))->render();
        return response()->json (['html' => $html]);
    }
    public function detail_document_admin($documen_id){
        $user_id=Session::get('admin_id');
        $data=Documents::where('id',$documen_id)->first();
        $post_man=Users::where('id',$data->user_id)->select('name')->first();
        return view('admin.detail_document_admin',compact('data','post_man'));
    }
    public function history_post(){
        $user_id=Session::get('admin_id');
        if(!isset($user_id)){
            return redirect()->back()->with('error','Bạn chưa đăng nhập');
        }
        $data= Notification::orderBy('id', 'DESC')
            ->limit(100)
            ->get();
        
        $years= Notification::select(DB::raw('YEAR(created_at) as year'))->distinct()->get();
        $count_data = count($data);
        return view('admin.history_post',compact('data','years','count_data'));
    }
    public function view_history_post(Request $request){
        $admin_id=Session::get('admin_id');
        $year=$request->year;
        
        $data=Notification::whereYear('created_at', $year)->get();
        $years= Notification::select(DB::raw('YEAR(created_at) as year'))->distinct()->get();
        $count_data= $data->count();
        
        return view('admin.view_history_post',compact('admin_id','data','years','year','count_data'));
    }
    public function delete_notifi_admin(Request $request){
        $notifi_id=$request->id;
        $document=Notification::where('id',$notifi_id)->first();
        Notification::where('id',$request->id)->delete();
        return response()->json([
            'status' => true
        ]);
    }
    public function search_admin(Request $request){
        $user_id=Session::get('user_id');
        $keyword=$request->keyword;
        $data1=Documents::where('document_number','like','%'.$keyword.'%') ->limit(200) ->orderBy('id', 'DESC') ->get();
        $data2=Documents::where('document_content','like','%'.$keyword.'%') ->limit(200) ->orderBy('id', 'DESC') ->get();
        $data= $data1->merge($data2);
        $count_data= $data->count();
        return view('admin.search_admin',compact('data','keyword','count_data'));
    }
    public function change_password_ad($admin_id){
        $user_id=Session::get('admin_id');
        if($user_id != $admin_id){
            return redirect()->back()->with('error','Không đủ quyền truy cập');
        }
        $user=Users::where('id',$admin_id)
        ->select('id','email','name')
        ->first();
        return view('admin.change_password_admin',compact('user'));
    }
   
    public function change_password_admin(Request $request){
        $password=$request->password;
        $id=$request->user_id;
        
        $result= DB::table('users')
        ->where('id', $id)
        ->where('role_id',0)
        ->first();
        
        if(Hash::check($password, $result->password )){
            $data=array();
            $data['password']=Hash::make($request->newpassword);
            Users::where('id',$id)->update($data);
            return redirect()->back()->with('message','Đổi mật khẩu thành công') ;
        }else{
            return redirect()->back()->with('error','Mật khẩu hiện tại không đúng') ;
        }
    }
}

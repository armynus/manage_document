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
        $data= Documents:: orderBy('id','DESC')
        ->limit(100)
        ->get();;
        $count_data = count($data);
        
        return view('admin.filter_document_admin',compact('years','data','admin_id','count_data'));
    }
    public function view_filter_document_admin(Request $request){
        $admin_id=Session::get('admin_id');
        $year=$request->year;
        $quarter=$request->quarter;
        
        if ($quarter==1) {
            $data=Documents::whereYear('document_time', $year)->whereMonth('document_time', '>=', 1)->whereMonth('document_time', '<=', 3)->orderBy('id','DESC')->get();
        }
        if ($quarter==2) {
            $data=Documents::whereYear('document_time', $year)->whereMonth('document_time', '>=', 4)->whereMonth('document_time', '<=', 6)->orderBy('id','DESC')->get();
        }
        if ($quarter==3) {
            $data=Documents::whereYear('document_time', $year)->whereMonth('document_time', '>=', 7)->whereMonth('document_time', '<=', 9)->orderBy('id','DESC')->get();
        }
        if ($quarter==4) {
            $data=Documents::whereYear('document_time', $year)->whereMonth('document_time', '>=', 10)->whereMonth('document_time', '<=', 12)->orderBy('id','DESC')->get();
        }
        $count_data = count($data);
        $years= Documents::select(DB::raw('YEAR(document_time) as year'))->distinct()->get();

        return view('admin.result_document_admin',compact('admin_id','data','years','year','quarter','count_data'));
    }
    public function delete_document_admin(Request $request){
        $document_id=$request->id;
        $document=Documents::where('id',$document_id)->first();
        $document_file=$document->document_file;
        if((file_exists('storage/document_folder/'.$document_file))==true){
            Notification::where('document_id',$request->id)->delete();
            $delete_file=unlink('storage/document_folder/'.$document_file);
            Documents::where('id',$request->id)->delete();
            return response()->json([
                'status' => true
            ]);
        }else{
            Notification::where('document_id',$request->id)->delete();
            Documents::where('id',$request->id)->delete();
            return response()->json([
                'status' => true
            ]);
        }
    }
    public function delete_detaildocument_admin(Request $request){
        $id=$request->id;
        $document=Documents::where('id',$id)->first();
        $document_file=$document->document_file;
        if((file_exists('storage/document_folder/'.$document_file))==true){
            Notification::where('document_id',$id)->delete();
            $delete_file=unlink('storage/document_folder/'.$document_file);
            Documents::where('id',$id)->delete();
            return response()->json([
                'status' => true
            ]);
        }else{
            Notification::where('document_id',$id)->delete();
            Documents::where('id',$id)->delete();
            return response()->json([
                'status' => true
            ]);
        }
    }
    public function edit_document_admin($id){
        $admin_id=Session::get('admin_id');
        $data=Documents::where('id',$id)->first();
       
        return view('admin.edit_document_admin',compact('data'));
    }
    public function edits_document_admin(Request $request){
        $document_id=$request->id;
        $document=Documents::where('id',$document_id)->first();
        $document_file=$document->document_file;
        $delete_file=unlink('storage/document_folder/'.$document_file);
        $data= array();
        $data['department_send']=$request->department_send;
        $data['document_number']=$request->document_number;
        $data['document_time']=$request->document_time;
        $data['document_content']=$request->document_content;
        $save_file= $request->file('document_file')->storeAs('public/document_folder', $request->file('document_file')->getClientOriginalName());
        $data['document_file']=$request->document_file->getClientOriginalName();
        $data['receiver']=$request->receiver;
        $data['updated_at']=date('Y-m-d H:i:s');
        Documents::where('id',$request->id)->update($data);
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
        $quarter=$request->quarter;
        
        if ($quarter==1) {
            $data=Notification::whereYear('created_at', $year)->whereMonth('created_at', '>=', 1)->whereMonth('created_at', '<=', 3)->get();
        }
        if ($quarter==2) {
            $data=Notification::whereYear('created_at', $year)->whereMonth('created_at', '>=', 4)->whereMonth('created_at', '<=', 6)->get();
        }
        if ($quarter==3) {
            $data=Notification::whereYear('created_at', $year)->whereMonth('created_at', '>=', 7)->whereMonth('created_at', '<=', 9)->get();
        }
        if ($quarter==4) {
            $data=Notification::whereYear('created_at', $year)->whereMonth('created_at', '>=', 10)->whereMonth('created_at', '<=', 12)->get();
        }
        $years= Notification::select(DB::raw('YEAR(created_at) as year'))->distinct()->get();
        $count_data= $data->count();
        
        return view('admin.view_history_post',compact('admin_id','data','years','year','quarter','count_data'));
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
}

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
use PhpOffice\PhpWord\TemplateProcessor;
use Pusher\Pusher;
use Session;
class UserController extends Controller
{
    public function index(){
        $data= Documents::get();
        $user_id=Session::get('user_id');
        $data_count=Documents::get()->count();
        $user_count=Users::where('status',0)->get()->count();
        $user_lock=Users::where('status',1)->get()->count();
        $noti_count=Notification::get()->count();
        return view('user.index',compact('data','user_id','data_count','user_count','user_lock','noti_count'));
    }
    public function post_document(){
        $user_id=Session::get('user_id');
        $user_name=Session::get('user_name');
       
        return view('user.post_document',compact('user_id','user_name',));
    }
    public function posts_document(Request $request){
        $data=array();
        $data['user_id']=$request->user_id;
        $data['department_send']=$request->department_send;
        $data['document_number']=$request->document_number;
        $data['document_time']=$request->document_time;
        $data['document_content']=$request->document_content;
        $data['receiver']=$request->receiver;
        $save_file= $request->file('document_file')->storeAs('public/document_folder', $request->file('document_file')->getClientOriginalName());
        $data['document_file']=$request->document_file->getClientOriginalName();
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
    
        $document= Documents::select('document_file')->get();
        foreach ($document as $key => $value) {
            if ($request->file('document_file')->getClientOriginalName() == $value->document_file) {
                return redirect()->back()->with('error','File đã tồn tại, vui lòng chọn file khác hoặc đổi tên file') ;
            }
        }
        $document_id=Documents::insertGetId($data);

        // them vao bang notification
        $notifi = array();
        $notifi['document_id']=$document_id;
        $notifi['user_id']=$request->user_id;
        $notifi['user_post']=$request->user_name;
        $notifi['document_number']=$request->document_number;
        $notifi['status']=0; // 0: chua doc, 1: da doc, 2: da xoa
        $notifi['created_at']=date('Y-m-d H:i:s');
        $notifi['updated_at']=date('Y-m-d H:i:s');
        $notifi_id=DB::table('notification')->insert($notifi);

        // pusher
        $data_pusher = array();
        $data_pusher['user_post'] = $request->user_name;
        $data_pusher['message'] = $data_pusher['user_post'] . ' vừa đăng một văn bản mới';
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            '2247a9ca0f5a2d5d09db',
            'b60db7679dd5124a431a',
            '1605770',
            $options
        );

        $pusher->trigger('NotificationNewDocument', 'notification-new-document', $data_pusher);
        return redirect()->back()->with('message','Thêm thành công') ;
    }
    public function download_document($id){
        $data=Documents::where('id',$id)->first();
        
        $file_path = public_path('storage/document_folder/'.$data->document_file);
        return response()->download($file_path);
    }
    public function word_export($id){
        $data=Documents::FindOrFail($id);
        $dd=date('d', strtotime($data->document_time));
        $mm=date('m', strtotime($data->document_time));
        $yy=date('Y', strtotime($data->document_time));
        $d=date('d', strtotime($data->created_at));
        $m=date('m', strtotime($data->created_at));
        $y=date('Y', strtotime($data->created_at));
        $templateProcessor = new TemplateProcessor('word_template/phieu_trinh_mau.docx');
        $templateProcessor->setValue('department_send', $data->department_send);
        $templateProcessor->setValue('document_number', $data->document_number);
        $templateProcessor->setValue('document_content', $data->document_content);
        $templateProcessor->setValue('dd', $dd);
        $templateProcessor->setValue('mm', $mm);
        $templateProcessor->setValue('yy', $yy);
        $templateProcessor->setValue('d', $d);
        $templateProcessor->setValue('m', $m);
        $templateProcessor->setValue('y', $y);
        $templateProcessor->setValue('document_content', $data->document_content);
        $templateProcessor->setValue('receiver', $data->receiver);
        
        $filename = 'Phieu Trinh Van Ban';
       
        $templateProcessor->saveAs($filename.'.docx');
        return response()->download($filename.'.docx')->deleteFileAfterSend(true);
    }
    public function manage_mydocument(){
        $user_id=Session::get('user_id');
        $data=Documents::where('user_id',$user_id)->get();
        
        return view('user.mydocument',compact('data'));
    }
    public function edit_mydocument($id){
        $user_id=Session::get('user_id');
        $data=Documents::where('id',$id)->first();
        if ($data->user_id != $user_id) {
            return redirect()->back();
        }
       
        return view('user.edit_mydocument',compact('data'));
    }
    public function edits_mydocument(Request $request){
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
    public function delete_mydocument(Request $request){
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
    public function delete_detaildocument_user(Request $request){
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
    public function filter_document(){
        $user_id=Session::get('user_id');
        $years= Documents::select(DB::raw('YEAR(document_time) as year'))->distinct()->get();
        $data= Documents:: orderBy('id','DESC')
        ->limit(100)
        ->get();
        $count_data = count($data);
        return view('user.filter_document',compact('years','data','count_data'));
    }
    public function view_filter_document(Request $request){
        $user_id=Session::get('user_id');
        $year=$request->year;
        $quarter=$request->quarter;
        
        if ($quarter==1) {
            $data=Documents::whereYear('document_time', $year)->whereMonth('document_time', '>=', 1)->whereMonth('document_time', '<=', 3)->get();
        }
        if ($quarter==2) {
            $data=Documents::whereYear('document_time', $year)->whereMonth('document_time', '>=', 4)->whereMonth('document_time', '<=', 6)->get();
        }
        if ($quarter==3) {
            $data=Documents::whereYear('document_time', $year)->whereMonth('document_time', '>=', 7)->whereMonth('document_time', '<=', 9)->get();
        }
        if ($quarter==4) {
            $data=Documents::whereYear('document_time', $year)->whereMonth('document_time', '>=', 10)->whereMonth('document_time', '<=', 12)->get();
        }
        $years= Documents::select(DB::raw('YEAR(document_time) as year'))->distinct()->get();
        $count_data = count($data);
        return view('user.result_document',compact('user_id','data','years','year','quarter','count_data'));
    }
    public function view_detail_document(){
        $user_id= Session::get('user_id');
       
        $notification= Notification::where('user_id','!=',$user_id)
            ->orderBy('id', 'DESC')
            ->limit(10)->get();
        $html = view('user.layouts.ajax_notifi',compact('notification'))->render();
        return response()->json (['html' => $html]);
    }
    public function detail_document($documen_id){
        $user_id=Session::get('user_id');
        $data=Documents::where('id',$documen_id)->first();
        if(!isset($data)){
            return redirect()->back()->with('error','Không tìm thấy văn bản');
        }
        $post_man=Users::where('id',$data->user_id)->select('name')->first();
        
        return view('user.detail_document',compact('data','post_man','user_id'));
    }
    public function history_post_user(){
        $user_id=Session::get('user_id');
        if(!isset($user_id)){
            return redirect()->back()->with('error','Bạn chưa đăng nhập');
        }
        $data= Notification::orderBy('id', 'DESC')
            ->limit(100)
            ->get();
        
        $years= Notification::select(DB::raw('YEAR(created_at) as year'))->distinct()->get();
        $count_data = count($data);
        
        return view('user.history_post',compact('data','years','count_data'));
    }
    public function view_history_post_user(Request $request){
        $user_id=Session::get('user_id');
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
        
        return view('user.view_history_post',compact('user_id','data','years','year','quarter','count_data'));
    }
    public function search(Request $request){
        $user_id=Session::get('user_id');
        $keyword=$request->keyword;
        $data1=Documents::where('document_number','like','%'.$keyword.'%') ->limit(200) ->orderBy('id', 'DESC') ->get();
        $data2=Documents::where('document_content','like','%'.$keyword.'%') ->limit(200) ->orderBy('id', 'DESC') ->get();
        $data= $data1->merge($data2);
        $count_data = count($data);
        return view('user.search_user',compact('data','keyword','count_data'));
    }
}

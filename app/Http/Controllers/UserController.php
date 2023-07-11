<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validate;
use App\Models\Users;
use App\Models\Documents;
use App\Models\CategoryDocument;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\View\Components\Alert;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Shared\ZipArchive;
use Pusher\Pusher;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DocumentsExport;
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
        $category=DB::table('category_document')->select('id','category_name')->get();
       
        return view('user.post_document',compact('user_id','user_name','category'));
    }
    public function posts_document(Request $request){
        if($request->category_id==1){
            $data=array();
            $data['stt']=$request->stt;
            $data['user_id']=$request->user_id;
            $data['department_send']=$request->department_send;
            $data['document_number']=$request->document_number;
            $data['category_id']=$request->category_id;
            $data['document_time']=$request->document_time;
            $data['document_content']=$request->document_content;
            $data['receiver']=$request->receiver;
            $data['signer']=$request->signer;
            $data['created_at']=date('Y-m-d H:i:s');
            $data['updated_at']=date('Y-m-d H:i:s');
    
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
            
            Session::flash('document_id',$document_id);
            return redirect()->back()->with('message','Thêm thành công') ;
        }
        $document= Documents::select('document_file')->get();
        foreach ($document as $key => $value) {
            if ($request->file('document_file')->getClientOriginalName() == $value->document_file) {
                return redirect()->back()->with('error','File đã tồn tại, vui lòng chọn file khác hoặc đổi tên file') ;
            }
        }
        $data=array();
        $data['stt']=$request->stt;
        $data['user_id']=$request->user_id;
        $data['department_send']=$request->department_send;
        $data['document_number']=$request->document_number;
        $data['category_id']=$request->category_id;
        $data['document_time']=$request->document_time;
        $data['document_content']=$request->document_content;
        $data['receiver']=$request->receiver;
        $data['signer']=$request->signer;
        // dd($request->file('document_file'));
        $save_file= $request->file('document_file')->storeAs('public/document_folder', $request->file('document_file')->getClientOriginalName());
        $data['document_file']=$request->document_file->getClientOriginalName();
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
    
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
        // $data_pusher = array();
        // $data_pusher['user_post'] = $request->user_name;
        // $data_pusher['message'] = $data_pusher['user_post'] . ' vừa đăng một văn bản mới';
        // $options = array(
        //     'cluster' => 'ap1',
        //     'encrypted' => true
        // );

        // $pusher = new Pusher(
        //     '2247a9ca0f5a2d5d09db',
        //     'b60db7679dd5124a431a',
        //     '1605770',
        //     $options
        // );

        // $pusher->trigger('NotificationNewDocument', 'notification-new-document', $data_pusher);
        Session::flash('document_id',$document_id);
        return redirect()->back()->with('message','Thêm thành công') ;
    }
   
    public function download_document($id){
        $data=Documents::where('id',$id)->first();
        if ($data->document_file == null) {
            return redirect()->back()->with('error','File không tồn tại') ;
        }
        $file_path = storage_path('app/public/document_folder/'.$data->document_file);
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
        $templateProcessor->setValue('receiver', $data->receiver);
        $templateProcessor->setValue('dd', $dd);
        $templateProcessor->setValue('mm', $mm);
        $templateProcessor->setValue('yy', $yy);
        $templateProcessor->setValue('d', $d);
        $templateProcessor->setValue('m', $m);
        $templateProcessor->setValue('y', $y);
        
        $filename = 'Phieu Trinh Van Ban '.$data->stt.'';
       
        $templateProcessor->saveAs($filename.'.docx');
        return response()->download($filename.'.docx')->deleteFileAfterSend(true);
    }
    public function manage_mydocument(){
        $user_id=Session::get('user_id');
        $data = DB::table('documents')
        ->where('user_id',$user_id)
        ->join('category_document', 'documents.category_id', '=', 'category_document.id')
        ->select('documents.*', 'category_document.category_name')
        ->orderBy('documents.id','ASC')
        ->get();
        
        $count_data = count($data);
        $years= Documents::select(DB::raw('YEAR(document_time) as year'))->distinct()->get();
        $categorys=DB::table('category_document')->select('id','category_name') ->get();
        return view('user.mydocument',compact('data','count_data','categorys','years'));
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
                Session::flash('document_id',$document_id);
                Documents::where('id',$request->id)->update($data);
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
                Session::flash('document_id',$document_id);
                Documents::where('id',$request->id)->update($data);
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
        Session::flash('document_id',$document_id);
        Documents::where('id',$request->id)->update($data);
        return redirect()->back()->with('message','Sửa thành công') ;
    }
    public function delete_mydocument(Request $request){
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
    public function delete_detaildocument_user(Request $request){
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
    public function filter_document(){
        $user_id=Session::get('user_id');
        $years= Documents::select(DB::raw('YEAR(document_time) as year'))->distinct()->get();
        $data = DB::table('documents')
        ->join('category_document', 'documents.category_id', '=', 'category_document.id')
        ->select('documents.*', 'category_document.category_name')
        ->orderBy('documents.id','DESC')
        ->limit(200)
        ->get();
        
        $count_data = count($data);
        $categorys=DB::table('category_document')->select('id','category_name') ->get();
        
        return view('user.filter_document',compact('years','data','count_data','categorys'));
    }
    public function view_filter_document(Request $request){
        $user_id=Session::get('user_id');
        $year=$request->year;
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
        return view('user.view_filter_document',compact('user_id','data','years','year','count_data','category','categorys'));
    }
    public function view_filter_mydocument(Request $request){
        $user_id=Session::get('user_id');
        $year=$request->year;
        $category_id=$request->category_id;
        $data = DB::table('documents')
            ->join('category_document', 'documents.category_id', '=', 'category_document.id')
            ->select('documents.*', 'category_document.category_name')
            ->orderBy('documents.id','ASC')
            ->where('category_id', $category_id)
            ->where('user_id', $user_id)
            ->whereYear('document_time', $year)
            ->get();
        
        $years= Documents::select(DB::raw('YEAR(document_time) as year'))->distinct()->get();
        $category=DB::table('category_document')->select('id','category_name')->where('id',$category_id) ->first();
        $categorys=DB::table('category_document')->select('id','category_name') ->get();
        // dd($category);
        $count_data = count($data);

        return view('user.view_filter_mydocument',compact('user_id','data','years','year','count_data','category','categorys'));
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
            ->limit(1000)
            ->get();
        
        $years= Notification::select(DB::raw('YEAR(created_at) as year'))->distinct()->get();
        $count_data = count($data);
        $categorys=DB::table('category_document')->select('id','category_name') ->get();
        return view('user.history_post',compact('data','years','count_data','categorys'));
    }
    public function view_history_post_user(Request $request){
        $user_id=Session::get('user_id');
        $year=$request->year;
        $data=Notification::whereYear('created_at', $year)->get();

        $years= Notification::select(DB::raw('YEAR(created_at) as year'))->distinct()->get();
        $count_data= $data->count();
        
        return view('user.view_history_post',compact('user_id','data','years','year','count_data'));
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
    public function change_password_us($user_id){
        $id=Session::get('user_id');
        if($user_id != $id){
            return redirect()->back()->with('error','Không đủ quyền truy cập');
        }
        $user=Users::where('id',$user_id)
        ->select('id','email','name')
        ->first();
        return view('user.change_password_user',compact('user'));
    }
   
    public function change_password_user(Request $request){
        $password=$request->password;
        $id=$request->user_id;
        
        $result= DB::table('users')
        ->where('id', $id)
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
    public function export_documents_excel( $year, $category_id){
        // $docu=Documents::whereYear('document_time', $year)
        //     ->where('category_id', $category_id)
        //     ->orderBy('stt', 'asc')
        //     ->get();
        // dd($docu);
        if($category_id==1){
            return Excel::download(new DocumentsExport($year, $category_id), 'Sổ vb đến '.$year.'.xlsx');
        }else{
            return Excel::download(new DocumentsExport($year, $category_id), 'Sổ vb đi '.$year.'.xlsx');
        }
        return Excel::download(new DocumentsExport($year, $category_id), 'documents.xlsx');
    }
}

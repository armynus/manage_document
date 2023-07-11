<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Chỉnh Sửa Tài Liệu</title>

    @include('user.layouts.head')
    <style>
		label.error{
			color: red;
            font-size: 14px;
            display: block;
            font-weight: 400;
		}
        .error {
            color: #5a5c69;
            /* font-size: 7rem; */
            font-size: 16px;
            line-height: 1;
            position: relative;
            width: 100%;
        }
       
	</style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('user.layouts.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('user.layouts.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- <h1 class="h3 mb-4 text-gray-800">Thêm Nhân Viên</h1> -->
                    <div class="row" style="justify-content: center;">
                        <div class="col-lg-8">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4"><b>Chỉnh Sửa Tài Liệu</b></h1>
                                </div>
                                @php
                                    $message = Session::get('message');
                                    $error = Session::get('error');
                                    if(isset($message)){
                                        echo '<div class="alert alert-success" role="alert">'.$message.'</div>';
                                        Session::put('message',null);
                                    }
                                    if(isset($error)){
                                        echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
                                        Session::put('error',null);
                                    }
                                @endphp
                                @if(Session::has('document_id'))
                                    <div class="alert alert-primary" role="alert"> In phiếu trình văn bản:
                                        <a href="{{route('word_export', Session::get('document_id'))}}" class="btn btn-large pull-right">
                                            <button type="button" class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                    <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                                    <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                                </svg>
                                            </button>
                                        </a>
                                    </div>

                                @endif
                                <form class="user" action="{{route('edits_mydocument')}} " method="POST" enctype="multipart/form-data" id="form_post_document">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <input type="hidden" name="user_id" value="{{$data->user_id}}">

                                    @if($data->category_id==1)
                                        <div class="form-group row" >
                                            <div class="col-sm-3 mb-3 mb-sm-0">
                                                <p class="text-center">Số đến</p>
                                            </div>
                                            <div class="col-sm-9" style="flex-wrap: wrap;">
                                                <input type="text" class="form-control form-control-user "
                                                    id="" placeholder=""  name="stt" value="{{$data->stt}}"> 
                                            </div>
                                        </div>
                                        <div class="form-group row" >
                                            <div class="col-sm-3 mb-3 mb-sm-0">
                                                <p class="text-center">Tên cơ quan gửi đến</p>
                                            </div>
                                            <div class="col-sm-9" style="flex-wrap: wrap;">
                                                <input type="text" class="form-control form-control-user "
                                                    id="" placeholder=""  name="department_send" value="{{$data->department_send}}"> 
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3 mb-3 mb-sm-0">
                                                <p class="text-center">Số & ký hiệu văn bản</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-user"
                                                    id="" placeholder=""  name="document_number" value="{{$data->document_number}}">
                                            </div>
                                        </div>
                                    @elseif($data->category_id==2)
                                        <div class="form-group row" >
                                            <div class="col-sm-3 mb-3 mb-sm-0">
                                                <p class="text-center">Số văn bản</p>
                                            </div>
                                            <div class="col-sm-9" style="flex-wrap: wrap;">
                                                <input type="text" class="form-control form-control-user "
                                                    id="" placeholder=""  name="document_number" value="{{$data->document_number}}"> 
                                            </div>
                                        </div>
                                        <div class="form-group row" >
                                            <div class="col-sm-3 mb-3 mb-sm-0">
                                                <p class="text-center">Người ký văn bản</p>
                                            </div>
                                            <div class="col-sm-9" style="flex-wrap: wrap;">
                                                <input type="text" class="form-control form-control-user "
                                                    id="" placeholder=""  name="signer" value="{{$data->signer}}"> 
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group row">
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">Ngày, tháng văn bản</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control form-control-user"
                                                id="" placeholder=""  name="document_time" value="{{$data->document_time}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">Tên loại và trích yếu nội dung</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" style=" min-height: 100px;" name="document_content">{{$data->document_content}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">Đơn vị hoặc người nhận</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-user"
                                                id="" placeholder=""  name="receiver"  value="{{$data->receiver}}"> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">File đăng tải</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="input-file-container">
                                                @if($data->category_id==1)
                                                    <input class="input-file" id="my-file" type="file" name="document_file1" accept="">
                                                    <label tabindex="0" for="my-file" class="input-file-trigger">Chọn văn bản</label>
                                                @else
                                                    <input class="input-file" id="my-file" type="file" name="document_file" accept="">
                                                    <label tabindex="0" for="my-file" class="input-file-trigger">Chọn văn bản</label>
                                                @endif
                                            </div>
                                            <p class="file-return"></p>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" >
                                        Chỉnh Sửa
                                    </button>
                                    
                                </form>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Phòng điện toán AgriBank Đồng Tháp</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- Thông báo realtime -->
    @include('user.layouts.realtime_notifi')
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    @include('user.layouts.logout_modal')
    

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin-2.min.js')}}"></script>
    <!-- Page level plugins -->
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('js/demo/datatables-demo.js')}}"></script>
    <!-- include jQuery validate library -->
    <script src="{{asset('js/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js')}}" type="text/javascript"></script>

<script>
$("#form_post_document").validate({
    rules: {
		"department_send": {
			required: true,
			maxlength: 255,
		},
        "document_number": {
            required: true,
            maxlength: 255,
        },
        "document_time": {
            required: true,
        },
        "document_content": {
            required: true,
            maxlength: 1000,
        },
        "receiver": {
            required: true,
            maxlength: 255,
        },
        "document_file": {
            required: true,
            maxlength: 500,
        },
	},
    messages: {
        "department_send": {
            required: "Vui lòng nhập tên cơ quan gửi đến",
            maxlength: "Tên cơ quan gửi đến không được vượt quá 255 ký tự",
        },
        "document_number": {
            required: "Vui lòng nhập số & ký hiệu văn bản",
            maxlength: "Số & ký hiệu văn bản không được vượt quá 255 ký tự",
        },
        "document_time": {
            required: "Vui lòng nhập ngày, tháng văn bản",
        },
        "document_content": {
            required: "Vui lòng nhập tên loại và trích yếu nội dung",
            maxlength: "Tên loại và trích yếu nội dung không được vượt quá 1000 ký tự",
        },
        "receiver": {
            required: "Vui lòng nhập đơn vị hoặc người nhận",
            maxlength: "Đơn vị hoặc người nhận không được vượt quá 255 ký tự",
        },
        "document_file": {
            required: "Vui lòng chọn file đăng tải",
            maxlength: "File đăng tải không được vượt quá 500 ký tự",
        },
    },
    submitHandler: function(form) {
        $(form).submit();
    }

});
</script>
<script>
    document.querySelector("html").classList.add('js');

    var fileInput  = document.querySelector( ".input-file" ),  
        button     = document.querySelector( ".input-file-trigger" ),
        the_return = document.querySelector(".file-return");
        
    button.addEventListener( "keydown", function( event ) {  
        if ( event.keyCode == 13 || event.keyCode == 32 ) {  
            fileInput.focus();  
        }  
    });
    button.addEventListener( "click", function( event ) {
        fileInput.focus();
        return false;
    });  
    fileInput.addEventListener( "change", function( event ) {  
        the_return.innerHTML = this.value;  
    });  
</script>
<script>
    $(document).ready(function(){
        $('#category_id').change(function(){

            var category_id=$(this).val();
            if(category_id==1){
                $("#uploadfile").css("display", "none");
            }else{
                $("#uploadfile").css("display", "flex");
            }
        })
    });
</script>
</body>

</html>
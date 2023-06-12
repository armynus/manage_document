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
                                <form class="user" action="{{route('edits_mydocument')}} " method="POST" enctype="multipart/form-data" id="form_post_document">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    
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
                                                <input class="input-file" id="my-file" type="file" name="document_file" accept="">
                                                <label tabindex="0" for="my-file" class="input-file-trigger">Chọn văn bản</label>
                                            </div>
                                            <p class="file-return"></p>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" >
                                        Đăng Tải
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
                        <span>Copyright &copy; Your Website 2020</span>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

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
</body>

</html>
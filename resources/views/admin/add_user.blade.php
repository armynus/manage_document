<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Thêm nhân viên</title>

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
        @include('admin.layouts.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.layouts.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Thêm Nhân Viên</h1>
                    <div class="row" style="justify-content: center;">
                        <div class="col-lg-8">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Tạo Tài Khoản Nhân Viên</h1>
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
                                <form class="user" action="{{route('adds_user')}}" method="POST" enctype="multipart/form-data" id="form_add_user">
                                    @csrf
                                    <div class="form-group">
                                        <input  class="form-control form-control-user" id="exampleInputEmail"
                                            placeholder="Tên Nhân Viên" name="name">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="exampleInputName"
                                            placeholder="Địa Chỉ Email " name="email">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Nhập Mật Khẩu"  name="password">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleRepeatPassword" placeholder="Nhập Lại Mật Khẩu"  name="repassword">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" >
                                        Tạo Tài Khoản
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
    @include('admin.layouts.logout_modal')
    

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
$("#form_add_user").validate({
    rules: {
		"name": {
			required: true,
			maxlength: 100,
            minlength: 5,
		},
        "email": {
            required: true,
            email: true,
        },
        "password": {
            required: true,
            minlength: 6,
        },
        "repassword": {
            required: true,
            equalTo: "#exampleInputPassword"
        },
        
	},
    messages: {
        "name": {
			required: "Vui lòng nhập tên nhân viên",
			maxlength: "Tên nhân viên không được quá 100 ký tự",
            minlength: "Tên nhân viên phải có ít nhất 5 ký tự",
		},
        "email": {
            required: "Vui lòng nhập email nhân viên",
            email: "Vui lòng nhập đúng định dạng email",
        },
        "password": {
            required: "Vui lòng nhập mật khẩu",
            minlength: "Mật khẩu phải có ít nhất 6 ký tự",
        },
        "repassword": {
            required: "Vui lòng nhập lại mật khẩu",
            equalTo: "Mật khẩu nhập lại không khớp",
        },
    },
    submitHandler: function(form) {
        $(form).submit();
    }

});
</script>
</body>

</html>
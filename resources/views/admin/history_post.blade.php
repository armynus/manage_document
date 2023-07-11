<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Lịch sử đăng tải</title>

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
                    <!-- <h1 class="h3 mb-2 text-gray-800">Lọc Tài Liệu Cần Tìm </h1> -->
                    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <form class="form-horizontal" id="form-filter" action="{{route('view_history_post')}}" method="POST">
                            @csrf
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">Lọc Thông Báo Theo Năm</h5>
                            </div>  
                        <div class="card-body"> 
                            <div class="">
                                    <select class="form-control" id="year" name="year" >
                                        <option value="">Chọn Năm</option>
                                        @foreach($years as $y)
                                            <option value="{{$y->year}}">{{$y->year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            </div>
                        
                        <div class="mt-3">
                            <button type="submit" class="form-control btn btn-primary">Lọc Thông Báo</button>
                        </div>
                        </form>
                        <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">{{$count_data}} thông báo gần nhất</h5>
                        </div>  
                        <div class="card-body"> 
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Thời gian đăng</th>
                                            <th>Tên người đăng</th>
                                            <th>Số & ký hiệu văn bản</th>
                                            <th>Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>Thời gian đăng</th>
                                            <th>Tên người đăng</th>
                                            <th>Số & ký hiệu văn bản</th>
                                            <th>Chức năng</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($data as $item)
                                        <tr>
                                            
                                            <td>{{$item->id}}</td>
                                            <td>
                                            {{date("H:i ", strtotime($item->created_at))}} Ngày {{date("d-m-Y ", strtotime($item->created_at))}}
                                            </td>
                                            <td>{{$item->user_post}}</td>
                                            <td>
                                                <a href="{{route('detail_document_admin', $item->document_id)}}">{{$item->document_number}}</a>
                                            </td>
                                           
                                            
                                    
                                            
                                            <td >
                                                
                                                <span  class="btn btn-large pull-right">
                                                    <span type="button" class="btn btn-danger delete_notifi" data-notifi_id="{{$item->id}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                                        </svg>
                                                    </span>
                                                </span>
                                            </td>
                                    
                                        </tr>
                                        @endforeach
                                        @include('admin.layouts.ajax_delete_notifi')
                                    </tbody>
                                </table>
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
    <!-- include Ajax  library -->
<script>
    
</script>
<script>
    $("#form-filter").validate({
    rules: {
        "year": {
            required: true,
        },
		"quarter": {
			required: true,
		},
	},
    messages: {
        "year": {
            required: "Chọn Năm Của Thông Báo",
        },
        "quarter": {
            required: "Chọn Quý Của Thông Báo",
 
        },
    },
    submitHandler: function(form) {
        $(form).submit();
    }
});
</script>   
</body>

</html>
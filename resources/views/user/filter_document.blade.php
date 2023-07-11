<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Thống kê tài liệu</title>

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
                    <!-- <h1 class="h3 mb-2 text-gray-800">Lọc Tài Liệu Cần Tìm </h1> -->
                    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <form class="form-horizontal" id="form-filter" action="{{route('view_filter_document')}}" method="POST">
                            @csrf
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">Lọc Văn Bản Theo Năm & Thể Loại</h5>
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
                            
                            <div class="mt-3">
                                <select class="form-control" id="category_id" name="category_id" >
                                    @foreach($categorys as $d)
                                        <option value="{{$d->id}}">{{$d->category_name}}</option>
                                    @endforeach
                                </select>
                            <div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="form-control btn btn-primary">Lọc Văn Bản</button>
                        </div>
                        </form>
                        <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">{{$count_data}} Văn bản tài liệu gần đây nhất</h5>
                        </div>  
                        <div class="card-body"> 
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Thể loại</th>
                                            <th>Ngày đăng</th>
                                            <th>Số & ký hiệu văn bản</th>
                                            <th>Ngày văn bản</th>
                                            <th>Tên loại và trích yếu nội dung</th>
                                            <th>Đơn vị hoặc người nhận</th>
                                            <th>Chức năng</th>
                                            
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Thể loại</th>
                                            <th>Ngày đăng</th>
                                            <th>Số & ký hiệu văn bản</th>
                                            <th>Ngày văn bản</th>
                                            <th>Tên loại và trích yếu nội dung</th>
                                            <th>Đơn vị hoặc người nhận</th>
                                            <th>Chức năng</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($data as $item)
                                        <tr>
                                            
                  
                                            <td>{{$item->category_name}} </td>
                                            <td>
                                                {{date('d-m-Y', strtotime($item->created_at))}}
                                            </td>
                               
                                            <td>
                                                <a href="{{route('detail_document', $item->id)}}">{{$item->document_number}}</a>
                                            </td>
                                            <td>
                                                {{date('d-m-Y', strtotime($item->document_time))}}
                                            </td>
                                            <td>{{$item->document_content}} </td> 
                                            <td>{{$item->receiver}} </td>
                                            <td >
                                                <a href="{{route('word_export', $item->id)}}" class="btn btn-large pull-right">
                                                    <button type="button" class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                                        </svg>
                                                    </button>
                                                </a>
                                                @if($item->document_file != '')
                                                <a href="{{route('download_document', $item->id)}}" class="btn btn-large pull-right">
                                                    <button type="button" class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
                                                            <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708z"></path>
                                                        </svg>
                                                    </button>
                                                </a>
                                                @endif

                                            </td>
                                        </tr>
                                        @endforeach
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
    <!-- include Ajax  library -->
<script>
$("#form-filter").validate({
    rules: {
        "year": {
            required: true,
        },
	},
    messages: {
        "year": {
            required: "Chọn Năm Của Tài Liệu",
        },

    },
    submitHandler: function(form) {
        $(form).submit();
    }

});
</script>   
</body>

</html>
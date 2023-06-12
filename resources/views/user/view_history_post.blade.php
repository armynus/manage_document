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
                        <form class="form-horizontal" id="form-filter" action="{{route('view_history_post_user')}}" method="POST">
                            @csrf
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">Lọc thông báo để xem chi tiết</h5>
                            </div>  
                        <div class="card-body"> 
                            <div class="">
                                <select class="form-control" id="year" name="year" value="{{$year}}">
                                    <option value="">Chọn Năm</option>
                                    
                                    @foreach($years as $y)
                                        <option name="year" value="{{$y->year}}" id="data-year{{$y->year}}">{{$y->year}}</option>
                                        @if($year == $y->year)
                                            <script>
                                                $('#data-year{{$y->year}}').attr('selected', 'selected');
                                            </script>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-3">
                                <select class="form-control" id="quarter" name="quarter" value="{{$quarter}}">
                                    <option value="">Chọn Quý</option>
                                    @if($quarter == 1)
                                        <option value="1" selected>Quý 1</option>
                                    @else
                                        <option value="1">Quý 1</option>
                                    @endif
                                    @if($quarter == 2)
                                        <option value="2" selected>Quý 2</option>
                                    @else
                                        <option value="2">Quý 2</option>
                                    @endif
                                    @if($quarter == 3)
                                        <option value="3" selected>Quý 3</option>
                                    @else
                                        <option value="3">Quý 3</option>
                                    @endif
                                    @if($quarter == 4)
                                        <option value="4" selected>Quý 4</option>
                                    @else
                                        <option value="4">Quý 4</option>
                                    @endif
                                </select>
                            </div>
                        <div class="mt-3">
                            <button type="submit" class="form-control btn btn-primary">Lọc</button>
                        </div>
                        </form>
                        <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">Quý {{$quarter}} năm {{$year}} có {{$count_data}} thông báo</h5>
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
                                            
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>Thời gian đăng</th>
                                            <th>Tên người đăng</th>
                                            <th>Số & ký hiệu văn bản</th>
                                       
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
                                                <a href="{{route('detail_document', $item->document_id)}}">{{$item->document_number}}</a>
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
    <!-- include Ajax  library -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
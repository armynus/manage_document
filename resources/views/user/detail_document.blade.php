<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Chi tiết tài liệu</title>

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
                                    <h1 class="h4 text-gray-900 mb-4"><b>Chi Tiết Văn Bản</b></h1>
                                </div>

                                    <div class="form-group row" >
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">Số đến:</p>
                                        </div>
                                        <div class="col-sm-9" style="flex-wrap: wrap;">
                                            <input type="text" class="form-control form-control-user "
                                                id="" placeholder=""  name="id" value="{{$data->id}} " disabled style="background-color: white"> 
                                        </div>
                                    </div>
                                    <div class="form-group row" >
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">Người đăng:</p>
                                        </div>
                                        <div class="col-sm-9" style="flex-wrap: wrap;">
                                            <input type="text" class="form-control form-control-user "
                                                id="" placeholder=""  name="id" value="{{$post_man->name}} " disabled style="background-color: white"> 
                                        </div>
                                    </div>
                                    <div class="form-group row" >
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">Ngày đăng:</p>
                                        </div>
                                        <div class="col-sm-9" style="flex-wrap: wrap;">
                                            <span  class="form-control form-control-user "
                                              name="created_at"  disabled style="background-color: white"> 
                                              {{date("H:i ", strtotime($data->created_at))}} Ngày {{date("d-m-Y ", strtotime($data->created_at))}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row" >
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">Ngày chỉnh sửa:</p>
                                        </div>
                                        <div class="col-sm-9" style="flex-wrap: wrap;">
                                            <span  class="form-control form-control-user "
                                              name="created_at"  disabled style="background-color: white"> 
                                              {{date("H:i ", strtotime($data->updated_at))}} Ngày {{date("d-m-Y ", strtotime($data->updated_at))}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row" >
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">Tên cơ quan gửi đến:</p>
                                        </div>
                                        <div class="col-sm-9" style="flex-wrap: wrap;">
                                            <input type="text" class="form-control form-control-user "
                                                id="" placeholder=""  name="department_send" value="{{$data->department_send}} " disabled style="background-color: white"> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">Số & ký hiệu văn bản:</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-user"
                                                id="" placeholder=""  name="document_number" value="{{$data->document_number}}" disabled style="background-color: white">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">Ngày, tháng văn bản:</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <span  class="form-control form-control-user" disabled style="background-color: white">
                                                Ngày {{date("d-m-Y", strtotime($data->document_time))}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">Tên loại và trích yếu nội dung:</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" style=" min-height: 100px; background-color: white;" name="document_content" disabled >{{$data->document_content}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">Đơn vị hoặc người nhận:</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-user"
                                                id="" placeholder=""  name="receiver"  value="{{$data->receiver}}" disabled style="background-color: white"> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">File đăng tải:</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-user"
                                                id="" placeholder=""  name="receiver"  value="{{$data->document_file}}" disabled style="background-color: white"> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 mb-3 mb-sm-0">
                                            <p class="text-center">Thao tác:</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="{{route('word_export', $data->id)}}" class="btn btn-large pull-right">
                                                    <button type="button" class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                                        <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                                    </svg>
                                                </button>
                                            </a> 
                                            <a href="{{route('download_document', $data->id)}}" class="btn btn-large pull-right">
                                                <button type="button" class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
                                                        <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708z"></path>
                                                    </svg>
                                                </button>
                                            </a>
                                            @if($user_id == $data->user_id)
                                                <a href="{{route('edit_mydocument', $data->id)}}" class="btn btn-large pull-right">
                                                    <span type="button" class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                        </svg>
                                                    </button>
                                                </a>
                                                <span  class="btn btn-large pull-right">
                                                    <span type="button" class="btn btn-danger delete_docu" data-docu_id="{{$data->id}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-folder-x" viewBox="0 0 16 16">
                                                            <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181L15.546 8H14.54l.265-2.91A1 1 0 0 0 13.81 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91H9v1H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zm6.339-1.577A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/>
                                                        <path d="M11.854 10.146a.5.5 0 0 0-.707.708L12.293 12l-1.146 1.146a.5.5 0 0 0 .707.708L13 12.707l1.146 1.147a.5.5 0 0 0 .708-.708L13.707 12l1.147-1.146a.5.5 0 0 0-.707-.708L13 11.293l-1.146-1.147z"/>
                                                        </svg>
                                                    </span>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
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
    $(document).ready(function(){
        $('.delete_docu').click(function(){
            var docu_id = $(this).data('docu_id');
            var _token = $('input[name="_token"]').val();
            console.log(docu_id);
            swal("Xác nhận xóa tài liệu?", {
                buttons: {
                    cancel: "Không",
                    catch: {
                    text: "Xác Nhận",
                    value: "catch",
                    },
                },
            })
            .then((value) => {
                switch (value) {
                    case "catch":
                    $.ajax({
                        url: '{{route('delete_detaildocument_user')}}',
                        method: 'POST',
                        data:{
                            id: docu_id,
                            _token: _token,
                        },
                        success: function(data){
                            location.replace('/filter_document');
                        },
                        error: function(data){
                            var errors = data.responseJSON;
                            console.log(errors);
                        }
                    });
                    break;
                    default:
                      
                }
            });
        });
    });
</script>
</body>

</html>
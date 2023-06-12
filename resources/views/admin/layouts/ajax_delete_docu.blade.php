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
                                                                url: '{{route('delete_document_admin')}}',
                                                                method: 'POST',
                                                                data:{
                                                                    id: docu_id,
                                                                    _token: _token,
                                                                },
                                                                success: function(data){
                                                                    $status = data.status; 
                                                                    if($status == true){
                                                                        location.reload();
                                                                    }
                                                                    else{
                                                                        swal("");
                                                                    }
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
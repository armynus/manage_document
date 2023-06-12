<script>
    $(document).ready(function(){
        $('.lock_user').click(function(){
            var user_id = $(this).data('user_id');
            var _token = $('input[name="_token"]').val();
            console.log(user_id);
            swal("Xác nhận khóa tài khoản?", {
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
                        url: '{{route('lock_user')}}',
                        method: 'POST',
                        data:{
                            user_id: user_id,
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
<script>
    $(document).ready(function(){
        $('.unlock_user').click(function(){
            var user_id = $(this).data('user_id');
            var _token = $('input[name="_token"]').val();
            console.log(user_id);
            swal("Mở khóa cho tài khoản?", {
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
                        url: '{{route('unlock_user')}}',
                        method: 'POST',
                        data:{
                            user_id: user_id,
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
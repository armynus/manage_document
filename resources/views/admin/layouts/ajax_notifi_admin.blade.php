                                    @foreach($notification as $notifi)
                                        <a class="dropdown-item d-flex align-items-center" href="{{route('detail_document_admin',$notifi->document_id)}}">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-primary">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">{{date("H:i ", strtotime($notifi->created_at))}} Ngày {{date("d-m-Y ", strtotime($notifi->created_at))}}</div>
                                                <span class="font-weight-bold">{{$notifi->user_post}} đã thêm văn bản {{$notifi->document_number}}</span>
                                            </div>
                                        </a>
                                        
                                    @endforeach
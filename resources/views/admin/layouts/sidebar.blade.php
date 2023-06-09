<ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #ae1c3f; 
    background-size: cover;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin_page')}}">
                <div class="sidebar-brand-icon ">
                    <img src="{{asset('hp-logo.png')}}" alt="" style="height: 50px">
                </div>
                <div class="sidebar-brand-text mx-3">ADMIN MANAGER</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{route('admin_page')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Thống kê</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                CHỨC NĂNG
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Qlý người dùng</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{route('add_user')}}">Thêm nhân viên</a>
                        <a class="collapse-item" href="{{route('list_staff')}}">Danh sách tài khoản</a>
                        <a class="collapse-item" href="{{route('list_staff_block')}}">Tài khoản đã khóa</a>
                    </div>
                </div>
            </li>

        

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Quản lý văn bản </span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                   
                        <a class="collapse-item" href="{{route('filter_document_admin')}}">Thống kê văn bản</a>
                        <a class="collapse-item" href="{{route('history_post')}}">Lịch sử đăng tải</a>
                        
                    </div>
                </div>
            </li>

           

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            

        </ul>
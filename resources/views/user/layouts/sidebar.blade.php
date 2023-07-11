<ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #ae1c3f; 
    background-size: cover;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('index')}}">
                <div class="sidebar-brand-icon ">
                    <img src="{{asset('hp-logo.png')}}" alt="" style="height: 50px">
                </div>
                <div class="sidebar-brand-text mx-3">SERVICE MANAGER</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{route('index')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Trang Chủ</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Chức Năng
            </div>
            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('filter_document')}}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Thống kê văn bản</span></a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('post_document')}}" 
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Đăng tải văn bản</span>
                </a>
                
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('manage_mydocument')}}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Văn bản của tôi</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('history_post_user')}}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Lịch sử đăng tải</span></a>
            </li>
            

           

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            

        </ul>
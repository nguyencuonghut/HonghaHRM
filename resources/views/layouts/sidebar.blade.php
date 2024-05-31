  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    @auth('admin')
    <a href="{{route('admin.home')}}" class="brand-link">
      <img src="{{ asset('images/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text">{{Auth::user()->name}}</span>
    </a>
    @else
    <a href="{{route('user.home')}}" class="brand-link">
      <img src="{{ asset('images/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text">{{Auth::user()->name}}</span>
    </a>
    @endauth

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @auth('admin')
          <li class="nav-item">
            <a href="{{route('admin.home')}}" class="nav-link {{ Request::is('admin') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link {{ Request::is('admin/profile*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-id-card"></i>
              <p>
                Hồ sơ của tôi
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('admin.logout')}}" class="nav-link">
              <i class="nav-icon fas fa-power-off"></i>
              <p>
                Đăng xuất
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('admin.recruitment.proposals.index')}}" class="nav-link">
              <i class="nav-icon fas fa-search-location"></i>
              <p>
                Tuyển dụng
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.recruitment.proposals.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yêu cầu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kế hoạch</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thông báo</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.recruitment.candidates.index')}}" class="nav-link {{ Request::is('admin/recruitment.candidates*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Ứng viên
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.calendars.index')}}" class="nav-link {{ Request::is('admin/calendars*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Lịch
              </p>
            </a>
          </li>
          @else
          <li class="nav-item">
            <a href="{{route('user.home')}}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link {{ Request::is('profile*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-id-card"></i>
              <p>
                Hồ sơ của tôi
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('user.logout')}}" class="nav-link">
              <i class="nav-icon fas fa-power-off"></i>
              <p>
                Đăng xuất
              </p>
            </a>
          </li>
          @endauth

          @auth('admin')
          <li class="nav-header">HỆ THỐNG</li>
          <li class="nav-item">
            <a href="{{route('admin.users.gallery')}}" class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Người dùng
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.admins.index')}}" class="nav-link {{ Request::is('admin/admins*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-lock"></i>
              <p>
                Người quản trị
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link {{ Request::is('admin/departments*') || Request::is('admin/divisions*') || Request::is('admin/positions*')? 'active' : '' }}">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>
                Tổ chức
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.departments.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Phòng ban</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.divisions.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bộ phận</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.positions.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Chức vụ</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{route('admin.company_jobs.index')}}" class="nav-link {{ Request::is('admin/company_jobs*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>
                Vị trí
              </p>
            </a>
          </li>
          @endauth
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

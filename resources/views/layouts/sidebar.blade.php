  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    @auth('admin')
    <a href="{{route('admin.dashboards.dashboard_1')}}" class="brand-link">
      <img src="{{ asset('images/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text">{{Auth::user()->name}}</span>
    </a>
    @else
    <a href="{{route('user.dashboards.dashboard_1')}}" class="brand-link">
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
          <li class="nav-item {{ Request::is('admin/dashboards*') ? 'menu-open' : '' }}">
            <a href="{{route('admin.dashboards.dashboard_1')}}" class="nav-link {{ Request::is('admin/dashboards*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.dashboards.dashboard_1')}}" class="nav-link {{ Request::is('admin/dashboards/dashboard_1*') ? 'active' : '' }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Dashboard 1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.dashboards.dashboard_2')}}" class="nav-link {{ Request::is('admin/dashboards/dashboard_2*') ? 'active' : '' }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Dashboard 2</p>
                </a>
              </li>
            </ul>
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

          <li class="nav-item {{ Request::is('admin/recruitment*') ? 'menu-open' : '' }}">
            <a href="{{route('admin.recruitment.proposals.index')}}" class="nav-link {{ Request::is('admin/recruitment*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-search-location"></i>
              <p>
                Tuyển dụng
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.recruitment.proposals.index')}}" class="nav-link {{ Request::is('admin/recruitment/proposals*') ? 'active' : '' }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Yêu cầu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Kế hoạch</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.recruitment.candidates.index')}}" class="nav-link {{ Request::is('admin/recruitment/candidates*') ? 'active' : '' }}"">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Ứng viên</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Request::is('admin/hr*') ? 'menu-open' : '' }}">
            <a href="{{route('admin.hr.employees.index')}}" class="nav-link {{ Request::is('admin/hr*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Hồ sơ nhân sự
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.hr.employees.index')}}" class="nav-link {{ Request::is('admin/hr/employees*') ? 'active' : '' }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Hồ sơ cá nhân</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.hr.probations.index')}}" class="nav-link {{ Request::is('admin/hr/probations*') ? 'active' : '' }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Thử việc</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.hr.workings.index')}}" class="nav-link {{ Request::is('admin/hr/workings*') ? 'active' : '' }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>QT công tác</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.hr.orgs.index')}}" class="nav-link {{ Request::is('admin/hr/orgs*') ? 'active' : '' }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Sơ đồ tổ chức</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.calendars.index')}}" class="nav-link {{ Request::is('admin/calendars*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Lịch
              </p>
            </a>
          </li>

          <li class="nav-item {{ Request::is('admin/reports*') ? 'menu-open' : '' }}">
            <a href="{{route('admin.reports.birthday')}}" class="nav-link {{ Request::is('admin/reports*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Báo cáo
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.reports.birthday')}}" class="nav-link {{ Request::is('admin/reports/birthday') ? 'active' : '' }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Sinh nhật</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.reports.situation')}}" class="nav-link {{ Request::is('admin/reports/situation') ? 'active' : '' }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Hoàn cảnh</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.reports.kid_policy')}}" class="nav-link {{ Request::is('admin/reports/kid_policy') ? 'active' : '' }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Chế độ 1/6</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.reports.seniority')}}" class="nav-link {{ Request::is('admin/reports/seniority') ? 'active' : '' }}">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Thâm niên</p>
                </a>
              </li>
            </ul>
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
          <li class="nav-item
                    {{
                    (Request::is('admin/departments*')
                    || Request::is('admin/divisions*')
                    || Request::is('admin/positions*')
                    || Request::is('admin/department_managers*')
                    || Request::is('admin/division_managers*'))
                    ? 'menu-open' : ''
                    }}"
          >
            <a href="#" class="nav-link
                    {{
                    Request::is('admin/departments*')
                    || Request::is('admin/divisions*')
                    || Request::is('admin/positions*')
                    || Request::is('admin/department_managers*')
                    || Request::is('admin/division_managers*')
                    ? 'active' : ''
                    }}">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>
                Tổ chức
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.departments.index')}}" class="nav-link {{ Request::is('admin/departments*') ? 'active' : '' }}">
                  &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Phòng ban</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.divisions.index')}}" class="nav-link {{ Request::is('admin/divisions*') ? 'active' : '' }}">
                  &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Bộ phận</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.positions.index')}}" class="nav-link {{ Request::is('admin/positions*') ? 'active' : '' }}">
                  &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Chức vụ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.department_managers.index')}}" class="nav-link {{ Request::is('admin/department_managers*') ? 'active' : '' }}">
                  &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Quản lý phòng/ban</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.division_managers.index')}}" class="nav-link {{ Request::is('admin/division_managers*') ? 'active' : '' }}">
                  &nbsp;&nbsp;&nbsp;&nbsp;<i class="far fa-circle nav-icon"></i>
                  <p>Quản lý tổ/nhóm</p>
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

          <li class="nav-item">
            <a href="{{route('admin.documents.index')}}" class="nav-link {{ Request::is('admin/documents*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-contract"></i>
              <p>
                Loại giấy tờ
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

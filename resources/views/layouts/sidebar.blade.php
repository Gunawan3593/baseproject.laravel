<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a :href="'/'">Demo App</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a :href="'/'">DA</a>
    </div>
    <ul class="sidebar-menu">
        <li class="nav-item">
          <menu-sidebar :href="'/'">
            <i class="fas fa-fire"></i> <span>Dashboard</span>
          </menu-sidebar>
        </li>
        @can('admin group')
        <li class="menu-header">Administrator</li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
            <i class="fas fa-columns"></i> <span>Pengaturan Akses</span>
          </a>
          <ul class="dropdown-menu">
            @can('user show')
            <li><menu-sidebar :href="'{{ route('user') }}'">Pengguna</menu-sidebar></li>
            @endcan
            @can('role show')
            <li><menu-sidebar :href="'{{ route('role') }}'">Group Hak Akses</menu-sidebar></li>
            @endcan
            @can('permission show')
            <li><menu-sidebar :href="'{{ route('permission') }}'">Hak Akses</menu-sidebar></li>
            @endcan
            @can('page show')
            <li><menu-sidebar :href="'{{ route('page') }}'">Halaman</menu-sidebar></li>
            @endcan
          </ul>
        </li>
        @can('reference show')
        <li class="nav-item">
          <menu-sidebar :href="'{{ route('reference') }}'">
            <i class="fas fa-link"></i> <span>Reference</span>
          </menu-sidebar>
        </li>
        @endcan
        @endcan
      </ul>
      <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
          <i class="fas fa-rocket"></i> Documentation
        </a>
      </div>
  </aside>
</div>
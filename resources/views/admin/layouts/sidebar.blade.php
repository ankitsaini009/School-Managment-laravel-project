<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="{{route('admin.dashboard')}}">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Manage Credentials</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="auth">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{route('teachers.index')}}">
              <i class="icon-star menu-icon"></i>
              <span class="menu-title">Teachers</span>
            </a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('classes.index')}}">
              <i class="icon-star menu-icon"></i>
              <span class="menu-title">Classes</span>
            </a></li>
          <li class="nav-item"><a class="nav-link" href="{{route('students.index')}}">
              <i class="icon-star menu-icon"></i>
              <span class="menu-title">Students</span>
            </a></li>
          <li class="nav-item"><a class="nav-link" href="{{route('schoolopen')}}">
              <i class="icon-star menu-icon"></i>
              <span class="menu-title">School</span>
            </a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{route('banners')}}">
        <i class="icon-star menu-icon"></i>
        <span class="menu-title">Banners</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{route('attendances.report')}}">
        <i class="icon-star menu-icon"></i>
        <span class="menu-title">Weekly Report</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{route('monthlyreport')}}">
        <i class="icon-star menu-icon"></i>
        <span class="menu-title">Monthly Report</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{route('setting.page')}}">
        <i class="ti-settings menu-icon"></i>
        <span class="menu-title">Settings</span>
      </a>
    </li>
  </ul>
</nav>
<div class="main-panel">
  <div class="content-wrapper">
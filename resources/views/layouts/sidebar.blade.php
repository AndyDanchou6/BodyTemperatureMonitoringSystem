<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ route('home') }}" class="app-brand-link">
      <span class="app-brand-logo demo"></span>
      <span class="app-brand-text demo menu-text fw-bolder ms-2" style="text-transform: none;">
        <img src="{{ asset('logo/4.png') }}" alt="">
      </span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>
  <div class="menu-inner-shadow"></div>
  <ul class="menu-inner py-1">

    <!-- Dashboard for Admin, Courier, SuperAdmin, Customer -->
    <li class="menu-item">
      <a href="{{ route('home') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div>Dashboard</div>
      </a>
    </li>

    <!-- Users Section for Admin and SuperAdmin -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Student Management</span></li>
    <li class="menu-item">
      <a href="{{ route('students.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div>Student Info</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="{{ route('temperature.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div>Temperature Records</div>
      </a>
    </li>
  </ul>
</aside>
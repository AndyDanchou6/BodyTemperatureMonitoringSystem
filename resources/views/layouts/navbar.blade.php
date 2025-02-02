<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>
  <ul class="navbar-nav flex-row align-items-center ms-auto">

    <!-- User dropdown -->
    <li class="nav-item navbar-dropdown dropdown-user dropdown">
      <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
          <img src="{{ asset('assets/img/user.png') }}" id="user_avatar_modal" alt="User Avatar" class="rounded-circle" style="width: 40px; height: 40px;" />
        </div>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="#">
            <div class="d-flex">
              <div class="flex-shrink-0 me-3">
                <div class="avatar avatar-online">
                  <img src="{{ asset('assets/img/user.png') }}" id="user_avatar_modal" alt="User Avatar" class="rounded-circle" style="width: 40px; height: 40px;" />
                </div>
              </div>
              <div class="flex-grow-1">
                <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                <small class="text-muted">{{ auth()->user()->role }}</small>
              </div>
            </div>
          </a>
        </li>
        <li>
          <div class="dropdown-divider"></div>
        </li>
        <!-- <li>
          <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="bx bx-user me-2"></i>
            <span class="align-middle">My Profile</span>
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="#">
            <span class="d-flex align-items-center align-middle">
              <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
              <span class="flex-grow-1 align-middle">Billing</span>
            </span>
          </a>
        </li> -->
        <!-- <li>
          <div class="dropdown-divider"></div>
        </li> -->
        <li>
          <a class="dropdown-item" id="logout_button">
            <i class="bx bx-power-off me-2"></i>
            <span class="align-middle">Log Out</span>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</nav>

<script>
  const logoutBtn = document.querySelector('#logout_button');

  logoutBtn.addEventListener('click', function() {
    swal({
      title: 'Logout!',
      text: 'Are you sure you want to logout?',
      icon: 'warning',
      buttons: ['No, later', 'Yes, logout'],
      dangerMode: true,
    }).then((result) => {
      if (result) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("logout") }}';

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        document.body.appendChild(form);
        form.submit();
      }
    });
  })
</script>
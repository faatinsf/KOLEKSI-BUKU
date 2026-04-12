<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <!-- Profile -->
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="profile" />
          <span class="login-status online"></span>
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">
            {{ Auth::user()->name ?? 'Vendor' }}
          </span>
          <span class="text-secondary text-small">Vendor</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}"
         href="{{ route('vendor.dashboard') }}">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>

    <!-- Master Menu -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#menuKantin" aria-expanded="false">
        <span class="menu-title">Master Menu</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-silverware-fork-knife menu-icon"></i>
      </a>
      <div class="collapse {{ request()->routeIs('vendor.menu.*') ? 'show' : '' }}" id="menuKantin">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link sub {{ request()->routeIs('vendor.menu.index') ? 'active' : '' }}"
               href="{{ route('vendor.menu.index') }}">Daftar Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link sub {{ request()->routeIs('vendor.menu.create') ? 'active' : '' }}"
               href="{{ route('vendor.menu.create') }}">Tambah Menu</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Pesanan Lunas -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('vendor.orders.index') ? 'active' : '' }}"
         href="{{ route('vendor.orders.index') }}">
        <span class="menu-title">Pesanan Lunas</span>
        <i class="mdi mdi-clipboard-check menu-icon"></i>
      </a>
    </li>

    <!-- Logout -->
    <li class="nav-item mt-auto">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="nav-link text-danger w-100 text-start border-0 bg-transparent">
          <i class="mdi mdi-logout menu-icon"></i>
          <span class="menu-title">Logout</span>
        </button>
      </form>
    </li>

  </ul>
</nav>

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
            {{ Auth::user()->name ?? 'User' }}
          </span>
          <span class="text-secondary text-small">
            {{ Auth::user()->role_id ?? 'Member' }}
          </span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/user/dashboard') }}">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>


    <!-- Buku -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#buku" aria-expanded="false">
        <span class="menu-title">Buku</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-book menu-icon"></i>
      </a>
      <div class="collapse" id="buku">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link sub {{ request()->routeIs('admin.buku.index') ? 'active' : '' }}" 
               href="{{ route('admin.buku.index') }}">Data Buku</a>
          </li>
        </ul>
      </div>
         <div class="collapse" id="buku">
           <ul class="nav flex-column sub-menu">
             <li class="nav-item">
            <a class="nav-link sub {{ request()->routeIs('admin.buku.create') ? 'active' : '' }}" href="{{ route('admin.buku.create') }}">Tambah Buku </a>
          </li>
        </ul>
      </div>
    </li>

  
    <!-- Kategori -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#kategori" aria-expanded="false">
        <span class="menu-title">Kategori</span>
        <i class="mdi mdi-contacts menu-icon"></i>
      </a>
      <div class="collapse" id="kategori">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
             <a class="nav-link sub {{ request()->is('admin/datakategori') ? 'active' : '' }}" href="{{ route('admin.kategori.index') }}">Data Kategori</a>
          </li>
        </ul>
      </div>
        <div class="collapse" id="kategori">
         <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link sub {{ request()->is('admin/create') ? 'active' : '' }}" href="{{ route('admin.kategori.create') }}">Tambah Kategori</a>
          </li>
        </ul>
      </div>

    </li>

    <li class="nav-item mt-auto">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="nav-link text-danger w-100 text-start border-0 bg-transparent {{ request()->is('admin/logout') ? 'active' : '' }}">
          <i class="mdi mdi-logout"></i> Logout
        </button>
      </form>
    </li>

  </ul>
  
</nav>

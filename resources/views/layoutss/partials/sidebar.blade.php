<nav class="app-sidebar">
  <div class="sidebar-header">
    <div class="user-info">
      <div class="avatar">
        <i class="mdi mdi-account"></i>
      </div>
      <div>
        <div class="fw-semibold">{{ Auth::user()->name ?? 'User' }}</div>
        <small>{{ Auth::user()->role_id ?? 'Member' }}</small>
      </div>
    </div>
  </div>

  <ul class="nav flex-column">

    <li class="nav-item">
      <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ url('/admin/dashboard') }}">
        <i class="mdi mdi-view-dashboard"></i>
        Dashboard
      </a>
    </li>

<li class="nav-item">
  <a class="nav-link {{ request()->is('admin/buku*') ? 'active fw-bold' : '' }}"
     data-bs-toggle="collapse"
     href="#menuBuku"
     role="button">
    <i class="mdi mdi-book"></i>
    Buku
    <i class="mdi mdi-chevron-down ms-auto"></i>
  </a>
    <div class="collapse" id="menuBuku">
      <a class="nav-link sub {{ request()->routeIs('admin.buku.index') ? 'active' : '' }}" 
      href="{{ route('admin.buku.index') }}">
      Data Buku
     </a>

     <div class="collapse" id="menuBuku">
      <a class="nav-link sub {{ request()->routeIs('admin.buku.create') ? 'active' : '' }}"
        href="{{ route('admin.buku.create') }}">
        Tambah Buku
      </a>
 </li>
  

    <li class="nav-item">
      <a class="nav-link {{ request()->is('admin/kategori') ? 'active' : '' }}" data-bs-toggle="collapse" href="#menuKategori">
        <i class="mdi mdi-tag-multiple"></i>
        Kategori
      </a>
      <div class="collapse" id="menuKategori">
        <a class="nav-link sub {{ request()->is('admin/datakategori') ? 'active' : '' }}" href="{{ route('admin.kategori.index') }}">Data Kategori</a>
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

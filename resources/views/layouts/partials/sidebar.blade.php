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

            <!-- Dokumen -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#dokumen" aria-expanded="false">
        <span class="menu-title">Dokumen</span>
        <i class="menu-arrow"></i>
         <i class="mdi mdi-book menu-icon"></i>
      </a>

      <div class="collapse" id="dokumen">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user.pdf.sertifikat') }}">
              Download Sertifikat (PDF)
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user.pdf.undangan') }}">
              Download Undangan (PDF)
            </a>
          </li>
        </ul>
      </div>
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
            <a class="nav-link sub {{ request()->routeIs('user.buku.index') ? 'active' : '' }}" 
               href="{{ route('user.buku.index') }}">Data Buku</a>
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
            <a class="nav-link sub {{ request()->is('user/datakategori') ? 'active' : '' }}" href="{{ route('user.kategori.index') }}">Data Kategori</a>
          </li>
        </ul>
      </div>
    </li>

    
  </ul>
</nav>

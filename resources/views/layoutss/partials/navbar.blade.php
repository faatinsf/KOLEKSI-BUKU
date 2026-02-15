<nav class="navbar navbar-expand-lg fixed-top app-navbar">
  <div class="container-fluid">

    <a class="navbar-brand fw-semibold text-white" href="{{ url('/') }}">
      <i class="mdi mdi-book-open-page-variant me-1"></i>
      Koleksi Buku
    </a>

    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
      <i class="mdi mdi-menu"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarMain">

      <form class="ms-auto me-3 d-none d-md-flex">
        <input class="form-control form-control-sm search-input" type="search" placeholder="Cari buku...">
      </form>

      <ul class="navbar-nav align-items-center">

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white d-flex align-items-center" data-bs-toggle="dropdown">
            <i class="mdi mdi-account-circle fs-4 me-1"></i>
            {{ Auth::user()->name ?? 'User' }}
          </a>

          <div class="dropdown-menu dropdown-menu-end shadow-sm">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="dropdown-item text-danger">
                <i class="mdi mdi-logout me-1"></i> Logout
              </button>
            </form>
          </div>
        </li>

      </ul>
    </div>
  </div>
</nav>

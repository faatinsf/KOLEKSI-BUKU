@include('layouts.partials.header')

<body>
  <div class="container-scroller">

    {{-- Navbar --}}
    @include('layouts.partials.navbar')

    <div class="container-fluid page-body-wrapper">

      {{-- Sidebar --}}
      @include('layouts.partials.sidebar')

      {{-- Main Content --}}
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>

        {{-- Footer --}}
        @include('layouts.partials.footer')
      </div>
    </div>
  </div>

@include('layouts.partials.scripts')

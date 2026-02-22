@include('layoutss.partials.header')

<body>
  <div class="container-scroller">

    {{-- Navbar --}}
    @include('layoutss.partials.navbar')

    <div class="container-fluid page-body-wrapper">

      {{-- Sidebar --}}
      @include('layoutss.partials.sidebar')

      {{-- Main Content --}}
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>

        {{-- Footer --}}
        @include('layoutss.partials.footer')
      </div>
    </div>
  </div>

@include('layoutss.partials.scripts')

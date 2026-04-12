@include('layoutsv.partials.header')

<body>
  <div class="container-scroller">

    {{-- Navbar --}}
    @include('layoutsv.partials.navbar')

    <div class="container-fluid page-body-wrapper">

      {{-- Sidebar --}}
      @include('layoutsv.partials.sidebar')

      {{-- Main Content --}}
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>

        {{-- Footer --}}
        @include('layoutsv.partials.footer')
      </div>
    </div>
  </div>

@include('layoutsv.partials.scripts')

@yield('scripts')

</body>
</html>
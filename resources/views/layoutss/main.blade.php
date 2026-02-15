@include('layoutss.partials.header')
<body>

  @include('layoutss.partials.navbar')

  <div class="app-wrapper">

    @include('layoutss.partials.sidebar')

    <main class="app-content">
      @yield('content')

      @include('layoutss.partials.footer')
    </main>

  </div>

</body>


@include('layoutss.partials.scripts')

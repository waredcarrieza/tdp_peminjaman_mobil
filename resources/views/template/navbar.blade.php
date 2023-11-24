<nav class="navbar navbar-expand-lg  navbar-dark bg-primary">
  <div class="container">
      <a class="navbar-brand" href="#">PT Transindo Data Perkasa</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          @if(Auth::check())
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/customer') }}">Customer</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/car') }}">Car</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/rent') }}">Rent</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/user/logout') }}">Logout</a>
          </li>
          @endif
        </ul>
      </div>
  </div>
</nav>
    
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                  <img src="{{ asset('img/User Admin Laki-Laki 1.jpg') }}" class="user-image img-circle elevation-2"
                      alt="User Image">
                  <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <!-- User image -->
                  <li class="user-header bg-success">
                      <img src="{{ asset('img/User Admin Laki-Laki 1.jpg') }}" class="img-circle elevation-2"
                          alt="User Image">
                      <p>
                          {{ Auth::user()->name }}
                          <small>{{ Auth::user()->role }}</small>
                      </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                      <a class="btn btn-default btn-flat col-md-12" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </li>
              </ul>
          </li>
      </ul>
  </nav>

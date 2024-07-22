<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
  <a class="navbar-brand ps-3 h1" href="#">A.E.U.T.N.A</a>
  <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
  <ul class="navbar-nav d-md-inline-block ms-auto me-0 me-md-3 my-2 my-md-0">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fas fa-user text-gray-400 fa-fw mr-2 text-warning"></i>&nbsp;Profile</a></li>
              <li><a class="dropdown-item" href="#"><i class="fas fa-headphones text-gray-400 fa-fw mr-2 text-warning"></i>&nbsp;Contactez-Nous</a></li>
              <li><hr class="dropdown-divider" /></li>
              <li><a class="dropdown-item" href="javascript:void(0)" id="logout-link"><i class="fas fa-sign-out-alt text-gray-400 fa-fw mr-2 text-warning"></i>&nbsp;Se déconnecter</a></li>
          </ul>
      </li>
  </ul>
</nav>
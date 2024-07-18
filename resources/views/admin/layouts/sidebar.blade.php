<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
  <div class="sb-sidenav-menu">
      <div class="nav">
          <div class="sb-sidenav-menu-heading">Core</div>
          <a class="nav-link" href="#">
              <div class="sb-nav-link-icon"><i class="fas fa-fw fa-tachometer-alt"></i></div>
              Tableau de bord
          </a>
          <div class="sb-sidenav-menu-heading">Interface</div>
          <a class="nav-link" href="{{ route('admin.axes.index') }}">
              <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
              Axes
          </a>
          <a class="nav-link" href="{{ route('admin.filieres.index') }}">
              <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
              Filières
          </a>
          <a class="nav-link" href="{{ route('admin.fonctions.index') }}">
              <div class="sb-nav-link-icon"><i class="fas fa-calendar"></i></div>
              Fonctions
          </a>
          <a class="nav-link" href="{{ route('admin.niveaux.index') }}">
              <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
              Niveaux
          </a>
          <a class="nav-link" href="{{ route('admin.membres.index') }}">
              <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
              Membres
          </a>
          <div class="sb-sidenav-menu-heading">ADMIN</div>
          <a class="nav-link" href="{{ route('admin.utilisateurs.index') }}">
              <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
              Utilisateurs
          </a>
      </div>
  </div>
</nav>
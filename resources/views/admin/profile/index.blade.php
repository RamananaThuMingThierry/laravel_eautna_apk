@extends('admin.admin')

@section('titre', 'Mon profile')
    
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.css" />
@endsection

@section('contenu')
  <div class="row my-2">
    <div class="col-lg-4">
      <div class="card shadow-sm rounded-0">
        <img src="{{ asset('images/logo.jpeg') }}" alt="" class="img-fluid w-100">
      </div>
    </div>
    <div class="col-lg-8">
      <div class="card rounded-0 shadow-sm">
        <form action="">
          <div class="card-header bg-white">
            <h1 class="text-center text-info bg">@yield('titre')</h1>
          </div>
          <div class="card-body">
            <div class="row">
              @include('widget.input',[
                'nom' => 'pseudo',
                'label' => 'Pseudo',
                'error' => 'PseudoUserError',
                'valeur' => $user->pseudo
              ])
              @include('widget.input',[
                'nom' => 'email',
                'type' => 'email',
                'label' => 'Adresse e-mail',
                'valeur' => $user->email,
                'error' => 'PseudoUserError',
              ])
            </div>
            <div class="row mt-3">
              @include('widget.input',[
                'nom' => 'contact',
                'label' => 'Contact',
                'error' => 'ContactUserError',
                'valeur' => $user->contact
              ])
              @include('widget.input',[
                'nom' => 'adresse',
                'label' => 'Adresse',
                'valeur' => $user->adresse,
                'error' => 'AdresseUserError',
              ])
            </div>
            <div class="row mt-3">
              @include('widget.input',[
                'nom' => 'status',
                'label' => 'Status',
                'disabled' => true,
                'error' => 'StatusUserError',
                'valeur' => $user->status ? 'Active' : 'En attente'
              ])
              @include('widget.input',[
                'nom' => 'roles',
                'label' => 'Rôle',
                'valeur' => $user->roles,
                'disabled' => true,
                'error' => 'RoleUserError',
              ])
            </div>
          </div>
          <div class="card-footer d-flex justify-content-end bg-white">
            <a href="javascript:void(0)" type="button" class="btn btn-primary">Modifier</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="row my-2">
    <div class="card shadow-sm rounded-0">
      <div class="card-header bg-white">
        <h3 class="text-muted">Changer votre mote de passe</h3>
      </div>
      <div class="card-body">

      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript">

  </script> 
@endsection
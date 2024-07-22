@extends('admin.admin')

@section('titre', 'Mon profile')
    
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.css" />
@endsection

@section('contenu')
  <div class="row my-2">
      <div class="col-lg-4">
        <div class="card p-3 rounded-0">
            <form action="" class="vstack gap-3" method="POST" encType="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="d-flex flex-column justify-content-center align-items-center">
                <img id="previewImage" class="img img-thumbnail fixed-size" name="photo" src="{{ asset($user->image ? $user->image : 'images/img.png') }}" height="355px" width="355px" alt="Image"/> 
                <div class="input-group d-flex justify-content-center mt-3">
                    <div class="custom-file">
                        <input type="file"  id="uploadPhoto" name="photo" class="form-control rounded-0 @error('photo') is-invalid @enderror"/> 
                        @error('photo')
                        <div class="invalid-feedback">
                          <span class="text-danger">{{ $message }}</span>
                        </div>
                      @enderror
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary rounded-0" type="submit">Modifier</button>
                    </div>
                    </div>
                </div>
              </form>    
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card rounded-0 shadow-sm p-2">
          <form action="" class="vstack gap-3">
            <div class="card-header bg-white">
              <h1 class="text-center mt-1 text-info bg">@yield('titre')</h1>
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
              <a href="javascript:void(0)" type="button" class="btn btn-primary mt-2">Modifier</a>
            </div>
          </form>
        </div>
      </div>
  </div>
  <div class="row">
    <div class="container">
      <div class="card shadow-sm rounded-0 my-2 p-2">
        <form action="" class="vstack gap-3">
          <div class="card-header bg-white">
            <h3 class="text-muted">Changer votre mote de passe</h3>
          </div>
          <div class="card-body">
            <div class="row">
              @include('widget.input',[
                'column' => 'col-md-4',
                'type' => 'password',
                'nom' => 'password_current',
                'label' => 'Ancien mot de passe',
                'error' => 'PasswordCurrentUserError'
              ])
              @include('widget.input',[
                'column' => 'col-md-4',
                'nom' => 'password',
                'type' => 'password',
                'label' => 'Mot de passe',
                'error' => 'PasswordUserError',
              ])
              @include('widget.input',[
                'column' => 'col-md-4',
                'nom' => 'password_confirmation',
                'type' => 'password',
                'label' => 'Confirmer votre mot de passe',
                'error' => 'PasswordConfirmationUserError',
              ])
            </div>
          </div>
          <div class="card-footer d-flex justify-content-end bg-white pt-3">
            <a href="" class="btn btn-danger" type="button">Retour</a>
            <button  class="btn btn-primary ms-2" type="submit">Modifier</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript">

  </script> 
@endsection
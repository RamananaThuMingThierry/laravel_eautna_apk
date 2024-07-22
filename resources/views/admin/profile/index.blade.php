@extends('admin.admin')

@section('titre', 'Mon profile')
    
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.css" />
@endsection

@section('contenu')
  <div class="row my-2">
      <div class="col-lg-4">
        <div class="card p-3 rounded-0">
          <form id="UpdatePhotoProfile" class="vstack gap-3" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="d-flex flex-column justify-content-center align-items-center">
                <img id="previewImage" class="img img-thumbnail img-fluid" width="325px" name="photo" src="{{ asset($user->image ? 'images/'.$user->image : 'images/img.png') }}" alt="Image"/> 
                <div class="input-group d-flex justify-content-center mt-3">
                    <div class="custom-file">
                        <input type="file" id="image" name="image" class="form-control rounded-0"/> 
                        <span class="text-danger error-message" id="PhotoProfileError"></span>
                    </div>
                    <div class="input-group-append">
                        <button id="btn-update-photo-profile" class="btn btn-primary rounded-0" type="submit">Modifier</button>
                    </div>
                </div>
            </div>
        </form>            
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card rounded-0 shadow-sm p-2">
          <form id="UpdateInformationProfile" class="vstack gap-3">
            <div class="card-header bg-white">
              <h1 class="text-center mt-1 text-info bg">@yield('titre')</h1>
            </div>
            <div class="card-body">
              @csrf
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
                  'error' => 'EmailUserError',
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
              <button type="submit" class="btn btn-primary  mt-2" id="btn-update-information-profile"><i class="fas fa-edit"></i>&nbsp;Modifier</button>
            </div>
          </form>
        </div>
      </div>
  </div>
  <div class="row">
    <div class="container">
      <div class="card shadow-sm rounded-0 my-2 p-2">
        <form id="UpdatePasswordProfile" class="vstack gap-3">
          <div class="card-header bg-white">
            <h3 class="text-muted">Changer votre mote de passe</h3>
          </div>
          <div class="card-body">
            @csrf
            <div class="row">
              @include('widget.input',[
                'column' => 'col-md-4',
                'type' => 'password',
                'nom' => 'current_password',
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
            <a href="{{ route('admin.membres.index') }}" class="btn btn-danger" type="button"><i class="fas fa-sign-out-alt fw-bold"></i>&nbsp;Retour</a>
            <button id="btn-update-password-profile" class="btn btn-primary ms-2" type="submit"><i class="fas fa-edit"></i>&nbsp;Modifier</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript">
    document.getElementById('image').addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('previewImage');
            output.src = reader.result;
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    });

    $(document).ready(function() {
        $('#UpdateInformationProfile').on('submit', function(e) {
            e.preventDefault();
            var button = $('#btn-update-information-profile');
            var originalContent = button.html();
            var loadingContent = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> patientez...';

            // Change the button content to show the spinner
            button.html(loadingContent);
            button.prop('disabled', true);
            
            $.ajax({
                url: "{{ route('admin.update.information.profile') }}",
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    if(response.success) {
                      window.location.href="{{ route('admin.profile') }}";
                      Swal.fire(
                          'Réuissi!',
                          response.message,
                          'success'
                      );
                      button.html(originalContent);
                      button.prop('disabled', false);
                    }
                },
                error: function(error) {
                  console.log(error);
                    if (error) {
                        $('#PhotoProfileError').html(error.responseJSON.errors.image);
                    }
                    button.html(originalContent);
                    button.prop('disabled', false);
                }
            });
        });

        $('#UpdatePasswordProfile').on('submit', function(e) {
            e.preventDefault();
            var button = $('#btn-update-password-profile');
            var originalContent = button.html();
            var loadingContent = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> patientez...';

            // Change the button content to show the spinner
            button.html(loadingContent);
            button.prop('disabled', true);
            
            $.ajax({
                url: "{{ route('admin.update.password.profile') }}",
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    if(response.success) {
                      window.location.href="{{ route('login') }}";
                      Swal.fire(
                        'Réuissi!',
                        response.message,
                        'success'
                      );
                    }
                },
                error: function(error) {
                  console.log(error);
                    if (error) {
                        $('#PasswordCurrentUserError').html(error.responseJSON.errors.current_password);
                        $('#PasswordUserError').html(error.responseJSON.errors.password);
                        $('#PasswordConfirmationUserError').html(error.responseJSON.errors.password_confirmation);
                    }
                    button.html(originalContent);
                    button.prop('disabled', false);
                }
            });
        });

        $('#UpdatePhotoProfile').on('submit', function(e) {
        e.preventDefault();
        var button = $('#btn-update-photo-profile');
        var originalContent = button.html();
        var loadingContent = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> patientez...';

        // Change the button content to show the spinner
        button.html(loadingContent);
        button.prop('disabled', true);

        var formData = new FormData(this);

        $.ajax({
            url: "{{ route('admin.update.photo.profile') }}",
            method: 'POST', // Change to POST for FormData
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if(response.success) {
                    Swal.fire(
                        'Réussi!',
                        response.message,
                        'success'
                    );
                }
                button.html(originalContent);
                button.prop('disabled', false);
            },
            error: function(error) {
                console.log(error);
                if (error.responseJSON && error.responseJSON.errors && error.responseJSON.errors.image) {
                    $('#PhotoProfileError').html(error.responseJSON.errors.image[0]);
                }
                button.html(originalContent);
                button.prop('disabled', false);
            }
        });
    });
  });
  </script> 
@endsection
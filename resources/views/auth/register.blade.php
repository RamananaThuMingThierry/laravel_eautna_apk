@extends('auth.app')

@section('titre', 'S\'inscrire')

@section('contenu')
  <div class="container">
    <div class="row vh-100 d-flex justify-content-center align-items-center">
      <div class="col-lg-6 col-md-8 col-sm-10 col-offset-lg-3 col-offset-md-2 col-offset-sm-1">
       <div class="card rounded-0 shadow-sm">
         <div class="card-body">
          <form id="registerForm">
            @csrf
            <div class="row d-flex justify-content-center">
             <img src="{{ asset('images/logo.jpeg') }}" class="w-25 img-fluid rounded-pill">
            </div>
            <div class="row d-flex justify-content-center my-2">
               <h2 class="text-dark">Inscription</h2>
            </div>
            <div class="row mt-2">
              @include('widget.input', [
                'column' => 'col-md-6 col-sm-12',
                'nom' => 'pseudo',
                'label' => 'Pseudo',
                'error' => 'PseudoUserError'
              ])
              @include('widget.input', [
                'column' => 'col-md-6 col-sm-12',
                'nom' => 'email',
                'type' => 'email',
                'label' => 'Adresse e-mail',
                'error' => 'EmailUserError'
              ])
            </div>
            <div class="row mt-2">
              @include('widget.input', [
                'column' => 'col-md-6 col-sm-12',
                'nom' => 'contact',
                'type' => 'number',
                'label' => 'Contact',
                'error' => 'ContactUserError'
              ])
              @include('widget.input', [
                'column' => 'col-md-6 col-sm-12',
                'nom' => 'adresse',
                'label' => 'Adresse',
                'error' => 'AdresseUserError'
              ])
            </div>
            <div class="row mt-2 mb-3">
              @include('widget.input', [
                'column' => 'col-12',
                'nom' => 'password',
                'type' => 'password',
                'label' => 'Mot de passe',
                'error' => 'PasswordUserError'
              ])
            </div>
            <div class="form-group">
               <div class="row mt-2 px-2">
                 <button type="submit" class="btn btn-warning d-block" id="btn-register">S'inscrire</button>
               </div>
            </div>
            <div class="row mt-3">
              <p>J'ai déjà un compte!<a href="{{ route('login') }}" class="text-decoration-none text-info fw-bold">&nbsp;Se connecter</p>
            </div>
          </form>
         </div>
       </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      $(document).ready(function() {
          $('#registerForm').on('submit', function(e) {
              e.preventDefault();
              var button = $('#btn-register');
              var originalContent = button.html();
              var loadingContent = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> patientez...';

              // Change the button content to show the spinner
              button.html(loadingContent);
              button.prop('disabled', true);
              
              $.ajax({
                  url: "{{ route('inscription.post') }}",
                  method: 'POST',
                  data: $(this).serialize(),
                  success: function(response) {
                      window.location.href="{{ route('admin.membres.index') }}";
                      Swal.fire(
                          'Supprimé!',
                          response.message,
                          'success'
                      );
                      $('#registerForm')[0].reset();
                      button.html(originalContent);
                      button.prop('disabled', false);
                  },
                  error: function(error){
                    if (error) {
                      $('#PseudoUserError').html(error.responseJSON.errors.pseudo);
                      $('#EmailUserError').html(error.responseJSON.errors.email);
                      $('#ContactUserError').html(error.responseJSON.errors.contact);
                      $('#AdresseUserError').html(error.responseJSON.errors.adresse);
                      $('#PasswordUserError').html(error.responseJSON.errors.password);
                      button.html(originalContent);
                      button.prop('disabled', false);
                  }
                  }
              });
          });
      });
  </script>
@endsection
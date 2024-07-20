@extends('auth.app')

@section('titre', 'Se connecter')

@section('contenu')
  <div class="container">
    <div class="row vh-100 d-flex justify-content-center align-items-center">
      <div class="col-lg-4 col-md-6 col-sm-10 col-offset-lg-4 col-offset-md-3 col-offset-sm-1">
       <div class="card rounded-0 shadow-sm">
         <div class="card-body">
          <form id="loginForm">
            @csrf
            <div class="row d-flex justify-content-center">
             <img src="{{ asset('images/logo.jpeg') }}" class="w-25 img-fluid rounded-pill">
            </div>
            <div class="row d-flex justify-content-center my-2">
               <h2 class="text-dark">Login</h2>
            </div>
            @include('widget.input', [
              'column' => 'col-12',
              'nom' => 'email',
              'type' => 'email',
              'label' => 'Adresse e-mail',
              'error' => 'EmailUserError'
            ])
            @include('widget.input', [
              'column' => 'col-12',
              'nom' => 'password',
              'type' => 'password',
              'label' => 'Mot de passe',
              'error' => 'PasswordUserError'
            ])
            <div class="row my-3">
              <div class="d-flex justify-content-between">
               <div class="form-group">
                 <input type="checkbox" id="remember" name="remember">
                 <label for="remember">Souvient de moi</label>
               </div>
               <a href="{{ route('password.request') }}" type="button" class="text-decoration-none">Mot de passe oublier</a>
              </div>
            </div>
            <div class="form-group">
               <div class="row mt-2 px-2">
                 <button type="submit" class="btn btn-warning d-block" id="btn-login">Se connecter</button>
               </div>
            </div>
            <div class="row mt-3">
              <p>N'avez-vous pas de compte?<a href="{{ route('inscription') }}" class="text-decoration-none text-info fw-bold">&nbsp;S'inscrire</p>
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
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            var button = $('#btn-login');
            var originalContent = button.html();
            var loadingContent = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> patientez...';

            // Change the button content to show the spinner
            button.html(loadingContent);
            button.prop('disabled', true);
            
            $.ajax({
                url: "{{ route('login.post') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    
                  console.log(response);

                    if(response.success) {
                        window.location.href = response.redirect_url;
                    }else{
                      Swal.fire(
                          'Attention!',
                          response.errors,
                          'error'
                      );
                      button.html(originalContent);
                      button.prop('disabled', false);
                    }
                },
                error: function(error) {
                  console.log(error);
                    if (error) {
                        $('#EmailUserError').html(error.responseJSON.errors.email);
                        $('#PasswordUserError').html(error.responseJSON.errors.password);
                    }
                    button.html(originalContent);
                    button.prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection
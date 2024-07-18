@extends('auth.app')

@section('titre', 'Se connecter')

@section('contenu')
  <div class="container">
    <div class="row vh-100 d-flex justify-content-center align-items-center">
      <div class="col-lg-4 col-md-6 col-sm-10 col-offset-lg-4 col-offset-md-3 col-offset-sm-1">
       <div class="card rounded-0 shadow-sm">
         <div class="card-body">
          <form>
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
              'error' => 'EmailMembreError'
            ])
            @include('widget.input', [
              'column' => 'col-12',
              'nom' => 'password',
              'type' => 'password',
              'label' => 'Mot de passe',
              'error' => 'PasswordMembreError'
            ])
            <div class="row my-3">
              <div class="d-flex justify-content-between">
               <div class="form-group">
                 <input type="checkbox" id="remember" name="remember">
                 <label for="remember">Souvient de moi</label>
               </div>
               <a href="#" type="button" class="text-decoration-none">Mot de passe oublier</a>
              </div>
            </div>
            <div class="form-group">
               <div class="row mt-2 px-2">
                 <button type="button" class="btn btn-warning d-block">Se connecter</button>
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
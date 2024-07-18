@extends('auth.app')

@section('titre', 'Se connecter')

@section('contenu')
  <div class="container">
    <div class="row vh-100 d-flex justify-content-center align-items-center">
      <div class="col-lg-6 col-md-8 col-sm-10 col-offset-lg-3 col-offset-md-2 col-offset-sm-1">
       <div class="card rounded-0 shadow-sm">
         <div class="card-body">
          <form>
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
                'error' => 'PseudoMembreError'
              ])
              @include('widget.input', [
                'column' => 'col-md-6 col-sm-12',
                'nom' => 'email',
                'type' => 'email',
                'label' => 'Adresse e-mail',
                'error' => 'EmailMembreError'
              ])
            </div>
            <div class="row mt-2">
              @include('widget.input', [
                'column' => 'col-md-6 col-sm-12',
                'nom' => 'contact',
                'type' => 'number',
                'label' => 'Contact',
                'error' => 'ContactMembreError'
              ])
              @include('widget.input', [
                'column' => 'col-md-6 col-sm-12',
                'nom' => 'adresse',
                'label' => 'Adresse',
                'error' => 'AdresseMembreError'
              ])
            </div>
            <div class="row mt-2 mb-3">
              @include('widget.input', [
                'column' => 'col-12',
                'nom' => 'password',
                'type' => 'password',
                'label' => 'Mot de passe',
                'error' => 'PasswordMembreError'
              ])
            </div>
            <div class="form-group">
               <div class="row mt-2 px-2">
                 <button type="button" class="btn btn-warning d-block">S'inscrire</button>
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
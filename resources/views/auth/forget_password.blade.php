@extends('auth.app')

@section('titre', 'Mot de passe oublier')

@section('styles')
    <style>
      @media (max-width: 767.98px) {
          .img-responsive {
              width: 25%;
              margin-bottom: 20px;
          }
      }
    </style>
@endsection 

@section('contenu')
  <div class="container">
    <div class="row d-flex justify-content-center align-items-center vh-100">
        <div class="col-lg-6 col-md-10 col-sm-10 col-offset-lg-3 col-offset-md-1 col-offset-sm-1">
          <form action="" method="post">
            @csrf
            @method('POST')
            <div class="card p-2 rounded-0 shadow-sm">
              <div class="card-header bg-white text-success"> <i class="fas fa-key"></i>&nbsp;Mot de passe oublier</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-4 col-md-5 text-center">
                    <img src="{{ asset('images/logo.jpeg') }}" class="img-fluid rounded-pill img-responsive" alt="">
                  </div>
                  <div class="col-lg-8 col-md-7">
                    <p>Nous comprenons, ça arrive. Entrez simplement votre adresse e-mail ci-dessous et nous vous enverrons un lien pour réinitialiser votre mot de passe !</p>
                    <div class="form-group">
                      <input type="email" name="email" class="form-control rounded-0 @error('email') is-invalid @enderror" placeholder="Entrer votre adresse e-mail" value="{{ old('email') }}"/>
                      @error('email')
                          <div class="invalid-feedback">
                          <span class="text-danger">{{ $message }}</span>
                          </div>
                      @enderror
                    </div>
                    <div class="row mt-3">
                      <p class="text-center">J'ai déjà un compte! <a href="{{ route('login') }}" class="text-info text-decoration-none">Se connecter</a></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer d-flex justify-content-end">
                <a href="{{ route('password.reset') }}" class="btn btn-outline-primary rounded-0" type="button">
                    <i class="fas fa-envelope fa-sm fa-fw mr-2 text-primary"></i>
                    Envoyer
                    </a>
                {{-- <button class="btn btn-outline-primary rounded-0" type="submit">
                    <i class="fas fa-envelope fa-sm fa-fw mr-2 text-primary"></i>
                    Envoyer
                    </button> --}}
              </div>
          </div>
          </form>
        </div>
    </div>
  </div>
@endsection
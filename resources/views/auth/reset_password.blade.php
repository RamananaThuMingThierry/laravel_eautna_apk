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
    <div class="row d-md-none mt-3"></div>
    <div class="row d-flex justify-content-center align-items-md-center align-items-sm-start vh-100">
        <div class="col-lg-6 col-md-10 col-sm-10 col-offset-lg-3 col-offset-md-1 col-offset-sm-1">
          <form action="" method="post">
            @csrf
            @method('POST')
            <div class="card p-2 rounded-0 shadow-sm">
              <div class="card-header bg-white text-success"> <i class="fas fa-key"></i>&nbsp;Réinitialiser votre mot de passe oublier</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-4 col-md-5 d-flex justify-content-center align-items-md-center align-items-sm-none">
                    <img src="{{ asset('images/logo.jpeg') }}" class="img-fluid rounded-pill img-responsive" alt="">
                  </div>
                  <div class="col-lg-8 col-md-7">
                    <div class="form-group">
                      <label for="email" class="text-secondary fw-bold">Adresse email</label>
                      <input type="email" name="email" class="form-control rounded-0 @error('email') is-invalid @enderror" placeholder="Entrer votre adresse e-mail" value="{{ old('email') }}"/>
                    </div>
                    <div class="form-group mt-2">
                      <label for="password" class="text-secondary fw-bold">Nouveau mot de passe</label>
                      <input type="password" name="password" class="form-control rounded-0 @error('password') is-invalid @enderror" placeholder="Entrer votre adresse e-mail" value="{{ old('password') }}"/>
                    </div>
                    <div class="form-group mt-2">
                      <label for="password" class="text-secondary fw-bold">Confirmer votre mot de passe</label>
                      <input type="password" name="password" class="form-control rounded-0 @error('password') is-invalid @enderror" placeholder="Entrer votre adresse e-mail" value="{{ old('password') }}"/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer d-flex justify-content-end">
                <a href="{{ route('password.reset') }}" class="btn btn-primary rounded-0" type="button">
                    <i class="fas fa-save fa-sm fa-fw mr-2"></i>
                    Valider
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
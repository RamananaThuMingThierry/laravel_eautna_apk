@extends('app')

@section('titre', 'En atttente')
   
@section('contenu')

@include('admin.modal.logout')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="row justify-content-center">
      <div class="col-md-8">
          <div class="card p-2 rounded-0">
              <div class="card-header bg-white text-success">En attente d'approbation</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <img src="{{ asset('img/fimpisava.png') }}" width="100%" alt="">
                  </div>
                  <div class="col-md-8 d-flex align-items-center justify-content-center">
                    <p>Bonjour Mr/Mm/Mlle <span class="text-primary">RAMANANA Thu MIng Thierry</span>, votre compte est en attente d'approbation par un administrateur. Vous recevrez un email une fois votre compte approuvé.</p>
                  </div>
                </div>
              </div>
              <div class="card-footer d-flex justify-content-end">
                <button class="btn btn-outline-danger rounded-0" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Se déconnecter
                    </button>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection
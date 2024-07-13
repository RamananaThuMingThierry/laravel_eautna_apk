@extends('admin.admin')

@section('contenu')
    <!-- 404 Error Text -->
    <div class="text-center my-5">
        <img class="img-fluid p-4" src="{{ asset('img/undraw_server_down_s-4-lk.svg') }}" style="width: 600px;">
        <p class="lead">Erreur du Serveur</p>
        <a href="{{ route('admin.dashboard') }}">&larr; Revenir au tableau de bord</a>
    </div>
@endsection

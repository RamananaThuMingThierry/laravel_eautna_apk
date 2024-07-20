@extends('admin.admin')

@section('contenu')
    <!-- 204 Error Text -->
    <div class="text-center my-5">
        <img class="img-fluid p-4" src="{{ asset('img/undraw_under_construction.svg') }}" style="width: 600px;">
        <p class="lead">Bientôt disponible!</p>
        <a href="#">&larr; Revenir au tableau de bord</a>
    </div>
@endsection

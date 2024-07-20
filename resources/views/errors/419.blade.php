@extends('errors.app')

@section('titre', 'Page expirée')

@section('content')
    <!-- 404 Error Text -->
    <div class="text-center my-5">
        <img class="img-fluid p-4" src="{{ asset('img/undraw_cancel_re_pkdm.svg') }}" style="width: 600px;">
        <p class="lead">Désolé, la page est expirée.</p>
        <a href="#">&larr; Revenir en arrière</a>
    </div>
@endsection

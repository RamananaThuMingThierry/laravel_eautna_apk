@extends('errors.app')

@section('titre', 'Page non trouvée')

@section('content')
    <!-- 404 Error Text -->
    <div class="text-center my-5">
        <img class="img-fluid p-4" src="{{ asset('img/undraw_page_not_found_re_e9o6.svg') }}" style="width: 600px;">
        <p class="lead">Désolé, la page que vous cherchez n'existe pas.</p>
        <a href="{{ route('admin.dashboard') }}">&larr; Revenir en arrière</a>
    </div>
@endsection

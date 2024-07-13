@extends('admin.admin')

@section('contenu')
    <!-- 403 Error Text -->
    <div class="text-center my-5">
        <img class="img-fluid p-4" src="{{ asset('img/undraw_access_denied_re_awnf.svg') }}" style="width: 600px;">
        <p class="lead">Vous n'êtes pas autorisé à effectuer cette opération</p>
        <a href="{{ route('admin.dashboard') }}">&larr; Revenir au tableau de bord</a>
    </div>
@endsection

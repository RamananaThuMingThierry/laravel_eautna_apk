@php
  $titre ??= '';
  $ids ??= '';
@endphp

<div class="row my-2">
  <div class="card rounded-0 shadow-sm">
    <div class="col-12 d-flex align-items-center justify-content-between">
      <h1 class="text-warning">@yield('titre')</h1>
      <button class="btn btn-sm btn-success shadow-sm d-flex align-items-center" id="{{ $ids }}">
        <i class="fas fa-plus p-2 text-white-50"></i>
        <span class="d-none d-sm-inline">&nbsp;{{ $titre }}</span>
      </button>
    </div>
  </div>
</div>
@php
    $label ??= '';
    $valeur ??= '';
@endphp
<div class="row">
  <div class="col-sm-5">
    <p class="text-secondary fw-bold mb-0">{{ $label }}</p>
  </div>
  <div class="col-sm-7">
    <p class="mb-0 text-dark">{{ $valeur }}</p>
  </div>
</div>
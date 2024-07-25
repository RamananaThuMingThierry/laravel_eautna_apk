@php
    $label ??= '';
    $valeur ??= '';
    $ids ??= '';
@endphp
<div class="row">
  <div class="col-sm-5">
    <p class="text-dark fw-bold mb-0">{{ $label }}</p>
  </div>
  <div class="col-sm-7">
    @if($label === 'Numéro carte' && intval($valeur) === 1)
      <p class="mb-0 text-dark">1</p>
    @elseif($valeur === 0 || $valeur === '0')
      <p class="mb-0 text-dark badge bg-danger w-50 py-3">En attente</p>
    @elseif($valeur === 1 || $valeur === '1')
      <p class="mb-0 badge bg-success w-50 py-3">Active</p>
    @elseif($valeur === 'Utilisateurs')
      <p class="mb-0 badge bg-success w-50 py-3">Utilisateurs</p>
    @elseif($valeur === 'Administrateurs')
      <p class="mb-0 badge bg-info w-50 py-3">Administrateurs</p>
    @else
      <p class="mb-0 text-dark" id="{{ $ids }}">{{ $valeur }}</p>
    @endif
  </div>
</div>

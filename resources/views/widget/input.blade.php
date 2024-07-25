<?php
  $type ??= 'text';
  $nom ??= '';
  $label ??= '';
  $error ??= '';
  $column ??= 'col-md-6';
  $valeur ??= '';
  $disabled ??= false;
?>

<div class="{{ $column }}">
  <div class="form-group">
    <label for="{{ $nom}}" class="fw-bold text-muted">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $nom}}" id="{{ $nom}}" value="{{ old($nom) ?? $valeur }}" class="bg-white rounded-0 form-control" {{ $disabled ? 'disabled' : '' }}>
    <span class="text-danger error-message" id="{{ $error }}"></span>
  </div>
</div>

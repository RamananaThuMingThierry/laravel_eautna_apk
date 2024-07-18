<?php
  $type ??= 'text';
  $nom ??= '';
  $label ??= '';
  $error ??= '';
  $column ??= 'col-md-6';
  $valeur ??= '';
?>

<div class="{{ $column }}">
  <div class="form-group">
    <label for="{{ $nom}}" class="fw-bold text-muted">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $nom}}" id="{{ $nom}}" value="{{ old($nom) ?? $valeur }}" class="rounded-0 form-control">
    <span class="text-danger error-message" id="{{ $error }}"></span>
  </div>
</div>
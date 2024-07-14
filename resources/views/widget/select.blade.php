<?php
  $nom ??= '';
  $label ??= '';
  $error ??= '';
  $column ??= 'col-md-6';
?>

<div class="{{ $column }}">
  <div class="form-group">
    <label for="{{ $nom}}" class="fw-bold text-muted">{{ $label }}</label>
    <select name="{{ $nom }}" id="{{ $nom }}" class="rounded-0 form-control">
    </select>
    <span class="text-danger error-message" id="{{ $error }}"></span>
  </div>
</div>
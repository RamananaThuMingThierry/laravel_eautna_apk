<?php
  $nom ??= '';
  $label ??= '';
  $error ??= '';
  $column ??= 'col-md-6';
  $collection ??= [];
?>

<div class="{{ $column }}">
  <div class="form-group">
    <label for="{{ $nom}}" class="fw-bold text-muted">{{ $label }}</label>
    <select name="{{ $nom }}" id="{{ $nom }}" class="rounded-0 form-control">
      @foreach ($collection as $key => $valeur)
          <option value="{{ $key }}">{{ $valeur }}</option>
      @endforeach
    </select>
    <span class="text-danger error-message" id="{{ $error }}"></span>
  </div>
</div>
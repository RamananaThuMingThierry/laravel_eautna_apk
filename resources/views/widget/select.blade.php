<?php
  $nom ??= '';
  $label ??= '';
  $error ??= '';
  $column ??= 'col-md-6';
  $collection ??= [];
  $nullable ??= false;
  $valeur ??= '';
?>

<div class="{{ $column }}">
  <div class="form-group">
      <label for="{{ $nom }}" class="fw-bold text-muted">{{ $label }}</label>
      <select name="{{ $nom }}" id="{{ $nom }}" class="form-control">
          @if(isset($nullable) && $nullable)
              <option value="">-- Aucun(e) --</option>
          @endif
          @foreach($collection as $key => $value)
              <option value="{{ $key }}" {{ $valeur == $key ? 'selected' : '' }}>
                  {{ $value }}
              </option>
          @endforeach
      </select>
      @if ($errors->has($nom))
          <span class="text-danger error-message">{{ $errors->first($nom) }}</span>
      @endif
  </div>
</div>
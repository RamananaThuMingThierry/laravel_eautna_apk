@php
    $nom_form_modal ??= '';
    $ids ??= '';
    $formData ??= '';
    $titre_formulaire ??= '';
    $input_id ??= '';
    $label_name ??= '';
    $input_name ??= '';
    $input_error_name ??= '';
    $btn_save ??= '';
@endphp

<div class="modal fade {{ $nom_form_modal }}" id="{{ $ids }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form id="{{ $formData }}">
    <div class="modal-dialog">
      <div class="modal-content rounded-0">
        <div class="modal-header">
          <h5 class="modal-title text-warning" id="{{ $titre_formulaire }}"></h5>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="h3">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @csrf
            <input type="hidden" name="{{ $input_id}}" id="{{ $input_id}}">
            <div class="form-group">
              <label for="{{ $input_name }}" class="text-dark">{{ $label_name }}</label>
              <input type="text" name="{{ $input_name }}" id="{{ $input_name }}" autofocus class="rounded-0 form-control">
              <span class="text-danger error-message" id="{{ $input_error_name }}"></span>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal" id="btnAnnuler"><i class="fas fa-sign-out-alt fw-bold"></i>&nbsp;Annuler</button>
          <button type="button" class="btn btn-primary rounded-0" id="{{ $btn_save }}"><i class="fas fa-save fw-bold"></i>&nbsp;Enregistrer</button>
        </div>
      </div>
    </div>
  </form>
</div>
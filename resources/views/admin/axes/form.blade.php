<div class="modal fade axes-form-modal" id="axes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form id="ajaxAxesForm">
    <div class="modal-dialog">
      <div class="modal-content rounded-0">
        <div class="modal-header">
          <h5 class="modal-title text-warning" id="titre-axes-form-modal">Formulaire axes</h5>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="h3">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @csrf
            <input type="hidden" name="axes_id" id="axes_id">
            <div class="form-group">
              <label for="nom_axes">Nom axes</label>
              <input type="text" name="nom_axes" id="nom_axes" autofocus class="rounded-0 form-control">
              <span class="text-danger error-message" id="ErreurNomaxes"></span>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal" id="btnAnnuler">Annuler</button>
          <button type="button" class="btn btn-primary rounded-0" id="btn-save-axes-form-modal">Enregistrer</button>
        </div>
      </div>
    </div>
  </form>
</div>
<div class="modal fade niveau-form-modal" id="niveau" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form id="ajaxNiveauForm">
    <div class="modal-dialog">
      <div class="modal-content rounded-0">
        <div class="modal-header">
          <h5 class="modal-title text-warning" id="titre-niveau-form-modal">Formulaire du niveau</h5>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="h3">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @csrf
            <input type="hidden" name="niveau_id" id="niveau_id">
            <div class="form-group">
              <label for="nom_niveau">Nom du niveau</label>
              <input type="text" name="nom_niveau" id="nom_niveau" class="rounded-0 form-control">
              <span class="text-danger error-message" id="ErreurNomNiveau"></span>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal" id="btnAnnuler">Annuler</button>
          <button type="button" class="btn btn-primary rounded-0" id="btn-save-niveau-form-modal">Enregistrer</button>
        </div>
      </div>
    </div>
  </form>
</div>
<div class="modal fade filiere-form-modal" id="filieres" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form id="ajaxFiliereForm">
    <div class="modal-dialog">
      <div class="modal-content rounded-0">
        <div class="modal-header">
          <h5 class="modal-title text-warning" id="titre-filiere-form-modal">Formulaire du Filière</h5>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="h3">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @csrf
            <input type="hidden" name="filiere_id" id="filiere_id">
            <div class="form-group">
              <label for="nom_filieres">Nom du filière</label>
              <input type="text" name="nom_filieres" id="nom_filieres" class="rounded-0 form-control">
              <span class="text-danger error-message" id="ErreurNomFiliere"></span>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal" id="btnAnnuler">Annuler</button>
          <button type="button" class="btn btn-primary rounded-0" id="btn-save-filiere-form-modal">Enregistrer</button>
        </div>
      </div>
    </div>
  </form>
</div>
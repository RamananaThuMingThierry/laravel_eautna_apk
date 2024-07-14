<div class="modal fade fonction-form-modal" id="fonctions" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form id="ajaxFonctionForm">
    <div class="modal-dialog">
      <div class="modal-content rounded-0">
        <div class="modal-header">
          <h5 class="modal-title text-warning" id="titre-fonction-form-modal">Formulaire du fonction</h5>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="h3">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @csrf
            <input type="hidden" name="fonction_id" id="fonction_id">
            <div class="form-group">
              <label for="nom_fonctions">Nom du fonction</label>
              <input type="text" name="nom_fonctions" id="nom_fonctions" class="rounded-0 form-control">
              <span class="text-danger error-message" id="ErreurNomFonction"></span>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal" id="btnAnnuler">Annuler</button>
          <button type="button" class="btn btn-primary rounded-0" id="btn-save-fonction-form-modal">Enregistrer</button>
        </div>
      </div>
    </div>
  </form>
</div>
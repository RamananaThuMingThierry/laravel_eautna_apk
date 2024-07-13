<div class="modal fade" id="deleteFonctionModal{{ $fonction->encrypted_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="exampleModalLabel">Suppression</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">X</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center">Souhaitez-vous vraiment supprimer cette fonction ?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger rounded-0" type="button" data-dismiss="modal">Annuler</button>
                <form action="{{ route('admin.fonctions.destroy', ['fonction' => $fonction->encrypted_id]) }}" method="post" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary rounded-0">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

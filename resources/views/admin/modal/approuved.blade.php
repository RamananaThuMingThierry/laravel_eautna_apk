<div class="modal fade" id="approuvedModal" tabindex="-1" role="dialog" aria-labelledby="approuvedModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success" id="approuvedModalLabel">Confirmation</h5>
            <button class="close text-danger" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <p class="text-center text-muted">Voulez-vous vraiment approuver cet utilisateur?</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-danger rounded-0" type="button" data-dismiss="modal">Annuler</button>
            <form action="{{ route('admin.user.approuved', ['user' => $user->encrypted_id]) }}" method="post" class="d-inline">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-primary rounded-0">Approuver</button>
            </form>
        </div>
    </div>
</div>
</div>
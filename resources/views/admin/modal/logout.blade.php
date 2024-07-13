<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-success" id="exampleModalLabel">Confirmation</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-danger">×</span>
            </button>
        </div>
        <div class="modal-body">
            <p class="text-center">Souhaitez-vous réellement vous déconnecter ?</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-danger rounded-0" type="button" data-dismiss="modal">Annuler</button>
            <form action="{{ route('logout') }}" method="post" class="d-inline">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-primary rounded-0">Se déconnecter</button>
            </form>
        </div>
    </div>
</div>
</div>
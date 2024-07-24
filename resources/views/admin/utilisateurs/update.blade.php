<div class="modal fade" id="UpdateUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="UpdateUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-warning" id="UpdateUserModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-4 col-sm-12">
            <div class="card rounded-0 p-3 shadow-sm rounded-0">
              <div class="card-body d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/img.png') }}" alt="Image" class="w-100 img-fluid">
              </div>
            </div>
          </div>
          <div class="col-lg-8 mt-3 col-sm-12">
            @include('widget.info',[
              'label' => 'Pseudo',
              'ids' => 'pseudo_user'
            ])
            <hr>
            @include('widget.info',[
              'label' => 'Email',
              'ids' => 'email_user'
            ])
            <hr>
            @include('widget.info',[
              'label' => 'Contact',
              'ids'   => 'contact_user'
            ])
            <hr>
            @include('widget.info',[
              'label' => 'Adresse',
              'ids' => 'adresse_user'
            ])
            <hr>
            @include('widget.info',[
              'label' => 'Rôles',
              'ids' => 'roles_user'
            ])
            <hr>
            @include('widget.info',[
              'label' => 'Status',
              'ids' => 'status_user'
            ])
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-sign-out-alt fw-bold"></i>&nbsp;Ferme</button>
      </div>
    </div>
  </div>
</div>
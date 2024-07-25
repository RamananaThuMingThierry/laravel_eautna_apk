<div class="modal fade" id="UpdateUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="UpdateUserModalLabel" aria-hidden="true">
  <form id="ApprouvedUserForm">
    @csrf
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
            <div class="col-lg-8 mt-3 col-sm-12 vstack gap-3">
              <input type="hidden" id="user_id" name="user_id">
              @include('widget.input', [
                'column' => 'col-md-12',
                'nom' => 'pseudo',
                'type' => 'text',
                'label' => 'Pseudo',
                'valeur' => '',
                'disabled' => true,
                'error' => 'PseudoUserError',
              ])
              @include('widget.input', [
                'column' => 'col-md-12',
                'nom' => 'email',
                'type' => 'text',
                'label' => 'Adresse e-mail',
                'valeur' => '',
                'disabled' => true,
                'error' => 'EmailUserError',
              ])
              @include('widget.input', [
                'column' => 'col-md-12',
                'nom' => 'contact',
                'type' => 'text',
                'label' => 'Contact',
                'valeur' => '',
                'disabled' => true,
                'error' => 'ContactUserError',
              ])
              @include('widget.select', [
              'column' => 'col-md-12',
              'nom' => 'roles',
              'label' => 'Rôles',
              'collection' => [
                  'Utilisateurs' =>'Utilisateurs',
                  'Administrateurs' =>'Administrateurs'
                ],
              'valeur' => '',
              'error' => 'RolesUserError',
              'nullable' => true
            ])
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="updateRoleButton" class="btn btn-primary btn-approuved-user-form"><i class="fas fa-edit fw-bold"></i>&nbsp;Modifier</button>
          <button type="button" id="approveButton" class="btn btn-warning btn-approuved-user-form"><i class="fas fa-check-circle fw-bold"></i>&nbsp;Approuver</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-sign-out-alt fw-bold"></i>&nbsp;Ferme</button>
        </div>
      </div>
    </div>
  </form>
</div>
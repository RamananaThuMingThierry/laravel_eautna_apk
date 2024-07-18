@extends('admin.admin')

@section('titre', 'Utilisateurs')
    
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.css" />
@endsection

@section('contenu')
  <div class="row my-2">
    <div class="card rounded-0 shadow-sm">
      <div class="col-12 d-flex align-items-center justify-content-start">
        <h1 class="text-warning pt-2">@yield('titre')</h1>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="card rounded-0 py-3 shadow-sm">
      <div class="col-12">
        <div class="table-responsive">
          <table id="datatables" class="table table-striped table-bordered display w-100">
            <thead class="table-dark">
              <th scope="col">Image(s)</th>
              <th scope="col">Pseudo</th>
              <th scope="col">Contact</th>
              <th scope="col">Rôles</th>
              <th scope="col">Status</th>
              <th scope="col" class="text-center">Actions</th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
    var table = $('#datatables').DataTable({
      ajax: "{{ route('admin.utilisateurs.index') }}",
      processing: false,
      serverSide: false,
      columns: [
          {
              data: 'image',
              render: function(data, type, row) {
                  return '<img src="{{ asset("images/img.png") }}" alt="Image" style="width:50px;height:auto;"/>';
              },
              className: 'text-center'
          },
          { data: 'pseudo', className: 'text-center' },
          { data: 'contact', className: 'text-center' },
          { data: 'roles', className: 'text-center' },
          { data: 'status', className: 'text-center' },
          { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
      ],
      dom: '<"row"<"col-sm-6"B><"col-sm-6">>' +
        '<"row mt-2"<"col-sm-6"l><"col-sm-6"f>>' +
        '<"row mt-2"<"col-sm-12"t>>' +
        '<"row ps-3 pe-3"<"col-sm-12 col-md-5 pt-2 p-0"i><"d-flex justify-content-center justify-content-md-end col-sm-12 col-md-7 p-0 pt-2"p>>',
      buttons: [
        {
          extend: 'csv',
          exportOptions: {
            columns: ':not(:last-child)'
          },
          text: '<i class="fas fa-file-csv" title="Exporter en CSV"></i>'
        },
        {
          extend: 'pdfHtml5',
          exportOptions: {
            columns: ':not(:last-child)'
          },
          text: '<i class="fas fa-file-pdf" title="Exporter en PDF"></i>',
          customize: function(doc) {
            if (doc.content[1].table.body[0].length === 1) {
              doc.content[1].table.widths = ['*'];
            }
          }
        },
        {
          extend: 'print',
          exportOptions: {
            columns: ':not(:last-child)'
          },
          text: '<i class="fas fa-print" title="Imprimer"></i>'
        },
        {
          text: '<i class="fas fa-sync-alt" title="Actualiser"></i>',
          action: function (e, dt, node, config) {
            location.reload(); // Recharge la page entière
          }
        }
      ],
      columnDefs: [
        { targets: -1, orderable: false }
      ],
      language: {
        "decimal": "",
        "emptyTable": "Aucune donnée disponible dans le tableau",
        "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
        "infoEmpty": "Affichage de 0 à 0 sur 0 entrées",
        "infoFiltered": "(filtré de _MAX_ entrées au total)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Afficher _MENU_ entrées",
        "loadingRecords": "Chargement...",
        "processing": "Traitement...",
        "search": 'Recherche :', // Utiliser une grille Bootstrap pour envelopper uniquement le champ de recherche
        "zeroRecords": "Aucun enregistrement ne correspondant à votre recheche",
        "aria": {
          "sortAscending": ": activer pour trier la colonne par ordre croissant",
          "sortDescending": ": activer pour trier la colonne par ordre décroissant"
        }
      },
      initComplete: function() {
        // Function to generate a random color
        function getRandomColor() {
          var letters = '0123456789ABCDEF';
          var color = '#';
          for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
          }
          return color;
        }

        // Apply random colors to buttons
        $('.dt-buttons button').each(function() {
          $(this).css('background-color', getRandomColor());
        });
      }
    });

    $('body').on('click', '#btn-delete-utilisateur-form-modal', function() {
        var utilisateur_id = $(this).data('id');
        var url = '{{ route("admin.utilisateurs.destroy", ":id") }}';
        url = url.replace(':id', utilisateur_id);

        Swal.fire({
          title: 'Êtes-vous sûr?',
          text: "Voulez-vous vraiment supprimer cet utilisateur?",
          icon: 'error',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Annuler',
          confirmButtonText: 'Oui, supprimer!'
        }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                  url: url,
                  method: 'DELETE',
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(response) {
                      if (response.success) {
                          Swal.fire(
                              'Supprimé!',
                              response.message,
                              'success'
                          );
                          table.ajax.reload(null, false);
                      }
                  },
                  error: function(error) {
                      Swal.fire(
                          'Erreur!',
                          'Une erreur s\'est produite lors de la suppression.',
                          'error'
                      );
                  }
              });
            }
        });
    });
  });
  </script> 
@endsection
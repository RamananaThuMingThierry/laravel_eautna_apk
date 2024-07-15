@extends('admin.admin')

@section('titre', 'Membres')
    
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.css" />
@endsection

@section('contenu')
    <div class="row mt-2">
      <div class="col-12 d-flex align-items-center justify-content-between mb-4">
        <h1 class="text-warning">@yield('titre')</h1>
        <a type="button" href="{{ route('admin.membres.create') }}" class="btn btn-sm btn-success shadow-sm d-flex align-items-center" id="btn-create-niveau-form-modal">
          <i class="fas fa-plus p-1 text-white-50"></i>
          <span class="d-none d-sm-inline">&nbsp;Nouveau membres</span>
        </a>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="tabel-responsive">
          <table id="datatables" class="table table-striped table-bordered display w-100">
            <thead class="table-dark">
              <th scope="col">Numéro Carte</th>
              <th scope="col">Nom</th>
              <th scope="col">Prénom</th>
              <th scope="col">Contact</th>
              <th scope="col" class="text-center">Actions</th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div></div>
    </div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#datatables').DataTable({
      ajax: "{{ route('admin.membres.index') }}",
      processing: false,
      serverSide: false,
      columns: [
          { data: 'numero_carte' },
          { data: 'nom' },
          { data: 'prenom' },
          { data: 'contact_personnel' },
          { data: 'action', name: 'action', orderable: false, searchable: false }
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
      }, initComplete: function() {
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
  });
</script> 
@endsection
@extends('admin.admin')

@section('titre', 'Fonctions')
    
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.css" />
@endsection

@section('contenu')
    @include('admin.fonctions.form')

    <div class="row mt-2">
      <div class="col-12 d-flex align-items-center justify-content-between mb-4">
        <h1 class="text-warning">@yield('titre')</h1>
        <button class="btn btn-sm btn-success shadow-sm d-flex align-items-center" id="btn-create-fonction-form-modal">
          <i class="fas fa-plus p-1 text-white-50"></i>
          <span class="d-none d-sm-inline">&nbsp;Nouvelle fonctions</span>
        </button>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="tabel-responsive">
          <table id="datatables" class="table table-striped table-bordered display w-100">
            <thead class="table-dark">
              <th scope="col">Nom</th>
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
      ajax: "{{ route('admin.fonctions.index') }}",
      processing: false,
      serverSide: false,
      columns: [
          { data: 'nom_fonctions' },
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

    // Ajouter le bouton "Actualiser" au DOM
    $('<button id="btn-refresh" class="btn btn-secondary ml-2">Actualiser</button>').appendTo('div.RefreshButton');

    // Recharger le tableau lorsque le bouton "Actualiser" est cliqué
    $('#btn-refresh').click(function() {
      table.ajax.reload(null, false); // Reload the data without resetting pagination
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#btn-create-fonction-form-modal').click(function(){
      $('.fonction-form-modal').modal('show');
      $('#btn-save-fonction-form-modal').dasabled = false;
      console.log("Le modal est ouvert");
      $('#titre-fonction-form-modal').html('Nouveau fonction');
      $('#btn-save-fonction-form-modal').html('Enregistrer');
      $('#nom_fonctions').val("");
      $('.error-message').html(''); 
    });

    // Modifier une filière
    $('body').on('click', '#btn-edit-fonction-form-modal', function() {
        var fonction_id = $(this).data('id');
        var url = '{{ route("admin.fonctions.edit", ":id") }}';
        url = url.replace(':id', fonction_id);
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
              console.log(response.fonction.nom_fonctions);
              $('.fonction-form-modal').modal('show');
              $('#titre-fonction-form-modal').html('Modifier une fonction');
              $('#btn-save-fonction-form-modal').html('Modifier');
              $('#fonction_id').val(response.fonction.id);
              $('#nom_fonctions').val(response.fonction.nom_fonctions);
              $('.error-message').html('');
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $('body').on('click', '#btn-delete-fonction-form-modal', function() {
        var fonction_id = $(this).data('id');
        var url = '{{ route("admin.fonctions.destroy", ":id") }}';
        url = url.replace(':id', fonction_id);

        Swal.fire({
          title: 'Êtes-vous sûr?',
          text: "Vous ne pourrez pas revenir en arrière!",
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

    $('#btn-save-fonction-form-modal').click(function() {
        var form = $('#ajaxFonctionForm')[0];
        var formData = new FormData(form);
        $('.error-message').html('');

        var button = this;
        var originalContent = button.innerHTML;
        var loadingContent = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> patientez...';

        // Change the button content to show the spinner
        button.innerHTML = loadingContent;
        button.disabled = true;
        var fonction_id = $('#fonction_id').val();

        if (fonction_id) {
            var url = '{{ route("admin.fonctions.update", ":id") }}';
            url = url.replace(':id', fonction_id);
            $.ajax({
              url: url,
              method: 'POST',
              processData: false,
              contentType: false,
              data: formData,
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                  'X-HTTP-Method-Override': 'PUT'
              },
              success: function(response) {
                  if (response) {
                      $('.fonction-form-modal').modal('hide');
                      Swal.fire({
                          position: "top",
                          title: 'Réussi!',
                          text: response.message,
                          icon: 'success',
                          confirmButtonText: 'OK'
                      });
                      table.ajax.reload(null, false);
                      button.innerHTML = originalContent;
                      button.disabled = false;
                  }
              },
              error: function(error) {
                  if (error) {
                      $('#ErreurNomfonction').html(error.responseJSON.errors.nom_fonctions);
                      button.innerHTML = originalContent;
                      button.disabled = false;
                  }
              }
            });
        } else {
            $.ajax({
                url: "{{ route('admin.fonctions.store') }}",
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    if (response) {
                        $('.fonction-form-modal').modal('hide');
                        Swal.fire({
                            position: "top",
                            title: 'Réussi!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        table.ajax.reload(null, false);
                        button.innerHTML = originalContent;
                        button.disabled = false;
                    }
                },
                error: function(error) {
                    if (error) {
                        $('#ErreurNomFonction').html(error.responseJSON.errors.nom_fonctions);
                        button.innerHTML = originalContent;
                        button.disabled = false;
                    }
                }
            });
        }
    });


    $('#btnAnnuler').click(function(){
      $('.fonction-form-modal').modal('hide');
    });

    $('.close').click(function(){
      $('.fonction-form-modal').modal('hide');
    });
  });
</script> 
@endsection
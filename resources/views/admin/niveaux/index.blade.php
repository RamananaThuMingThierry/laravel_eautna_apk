@extends('admin.admin')

@section('titre', 'Niveaux')
    
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.css" />
@endsection

@section('contenu')
    @include('widget.form_modal',[
      'nom_form_modal' => 'niveau-form-modal',
      'ids' => 'niveau',
      'formData' => 'ajaxNiveauForm',
      'titre_formulaire' => 'titre-niveau-form-modal',
      'input_id' => 'niveau_id',
      'label_name' => 'Nom du niveau',
      'input_name' => 'nom_niveau',
      'input_error_name' => 'ErreurNomNiveau',
      'btn_save' => 'btn-save-niveau-form-modal'
    ])
    
    @include('widget.header_page', [
      'titre' => 'Nouveau niveau',
      'ids' => 'btn-create-niveau-form-modal'
    ])

    @include('widget.body_page')
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#datatables').DataTable({
      ajax: "{{ route('admin.niveaux.index') }}",
      processing: false,
      serverSide: false,
      columns: [
          { data: 'nom_niveau' },
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#btn-create-niveau-form-modal').click(function(){
      $('.niveau-form-modal').modal('show');
      $('#btn-save-niveau-form-modal').dasabled = false;
      console.log("Le modal est ouvert");
      $('#titre-niveau-form-modal').html('Nouveau niveau');
      $('#nom_niveau').val("");
      $('.error-message').html(''); 
    });

    // Modifier une filière
    $('body').on('click', '#btn-edit-niveau-form-modal', function() {
        var niveau_id = $(this).data('id');
        var url = '{{ route("admin.niveaux.edit", ":id") }}';
        url = url.replace(':id', niveau_id);
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
              console.log(response.niveau.nom_niveau);
              $('.niveau-form-modal').modal('show');
              $('#titre-niveau-form-modal').html('Modifier une niveau');
              $('#btn-save-niveau-form-modal').html('Modifier');
              $('#niveau_id').val(response.niveau.id);
              $('#nom_niveau').val(response.niveau.nom_niveau);
              $('.error-message').html('');
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $('body').on('click', '#btn-delete-niveau-form-modal', function() {
        var niveau_id = $(this).data('id');
        var url = '{{ route("admin.niveaux.destroy", ":id") }}';
        url = url.replace(':id', niveau_id);

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

    $('#btn-save-niveau-form-modal').click(function() {
        var form = $('#ajaxNiveauForm')[0];
        var formData = new FormData(form);
        $('.error-message').html('');

        var button = this;
        var originalContent = button.innerHTML;
        var loadingContent = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> patientez...';

        // Change the button content to show the spinner
        button.innerHTML = loadingContent;
        button.disabled = true;
        var niveau_id = $('#niveau_id').val();

        if (niveau_id) {
            var url = '{{ route("admin.niveaux.update", ":id") }}';
            url = url.replace(':id', niveau_id);
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
                      $('.niveau-form-modal').modal('hide');
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
                      $('#ErreurNomNiveau').html(error.responseJSON.errors.nom_niveau);
                      button.innerHTML = originalContent;
                      button.disabled = false;
                  }
              }
            });
        } else {
            $.ajax({
                url: "{{ route('admin.niveaux.store') }}",
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    if (response) {
                        $('.niveau-form-modal').modal('hide');
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
                        $('#ErreurNomNiveau').html(error.responseJSON.errors.nom_niveau);
                        button.innerHTML = originalContent;
                        button.disabled = false;
                    }
                }
            });
        }
    });

    $('#btnAnnuler').click(function(){
      $('.niveau-form-modal').modal('hide');
    });

    $('.close').click(function(){
      $('.niveau-form-modal').modal('hide');
    });
  });
</script> 
@endsection
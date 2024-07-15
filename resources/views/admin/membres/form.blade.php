@extends('admin.admin', ['titre' => 'Nouveau Membre'])

@section('titre', 'Nouveau membre')

@section('styles')
  <style>

    #uploadPhoto{
      margin-top: 37px;
    }

    .custom-img{
      width: 275px;
      height: 275px;
      object-fit: cover;
    }

    @media (min-width: 768px) { /* Medium screens (md) and up */
      .custom-img {
        max-width: 267px;
        max-height: 267px;
      }
    }

    @media (min-width: 992px) { /* Large screens (lg) and up */
      .custom-img {
        max-width: 267px;
        max-height: 267px;
      }
    }
  </style>
@endsection

@section('contenu')
  <div class="card my-3 rounded-0">
    <div class="card-header rounded-0 bg-white">
      <h2 class="text-center text-warning">@yield('titre')</h2>
    </div>
    <div class="card-body bg-white">
      <form id="ajaxMembreForm" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="membre_id" id="membre_id">
        <div class="row mb-2">
          <div class="col-lg-4">
            <div class="d-flex flex-column justify-content-center align-items-center">
              <img src="{{ asset('images/img.png') }}" alt="Pas d'image" class="custom-img" id="previewImage">
              <input type="file" id="uploadPhoto" name="image" class="form-control rounded-0"/>
              <span class="text-danger error-message" id="ImageMembreError"></span>
            </div>
          </div>            
          <div class="col-lg-8">
            {{-- Numéro carte et cin --}}
            <div class="row mb-2">
              @include('widget.input', [
                'type' => 'number',
                'nom' => 'numero_carte',
                'label' => 'Numéro carte',
                'error' => 'NumeroCarteMembreError',
              ])
              @include('widget.input', [
                'nom' => 'cin',
                'type' => 'number',
                'label' => 'Carte d\'Identité National',
                'error' => 'CinMembreError',
              ])
            </div>
              {{-- Nom et Prénom --}}
            <div class="row mb-2">
              @include('widget.input', [
                'nom' => 'nom',
                'label' => 'Nom',
                'error' => 'NomMembreError',
              ])
              @include('widget.input', [
                'nom' => 'prenom',
                'label' => 'Prénom',
                'error' => 'PrenomMembreError',
              ])
            </div>
            {{-- Date et Lieu de naissance --}}
            <div class="row mb-2">
              @include('widget.input', [
                'nom' => 'date_de_naissance',
                'type' => 'date',
                'label' => 'Date de naissance',
                'error' => 'DdnMembreError',
              ])
              @include('widget.input', [
                'nom' => 'lieu_de_naissance',
                'label' => 'Lieu de naissance',
                'error' => 'LdnMembreError',
              ])
            </div>
            {{-- Adresse e-mail et Genre --}}
            <div class="row mb-2">
              @include('widget.input', [
                'nom' => 'email',
                'type' => 'email',
                'label' => 'Adresse email',
                'error' => 'EmailMembreError',
              ])
              @include('widget.select', [
                'nom' => 'genre',
                'label' => 'Genre',
                'collection' => [
                  'homme' =>'Homme',
                  'femme' =>'Femme'
                ],
                'error' => 'GenreMembreError',
              ])
            </div>
              {{-- Axes et Section --}}
              <div class="row mb-2">
              @include('widget.select', [
                'nom' => 'axes_id',
                'label' => 'Axes',
                'collection' => $axes,
                'error' => 'AxesMembreError',
              ])
              @include('widget.select', [
                'nom' => 'sections_id',
                'label' => 'Section',
                'collection' => $sections,
                'error' => 'SectionMembreError',
              ])
            </div>
          </div>
        </div>
        {{-- Fonction, Filière et Niveau --}}
        <div class="row mb-2">
          @include('widget.select', [
            'column' => 'col-md-4',
            'nom' => 'fonctions_id',
            'label' => 'Fonctions',
            'collection' => $fonctions,
            'error' => 'FonctionMembreError',
          ])
          @include('widget.select', [
            'column' => 'col-md-4',
            'nom' => 'filieres_id',
            'label' => 'Filières',
            'collection' => $filieres,
            'error' => 'FiliereMembreError',
          ])
          @include('widget.select', [
            'column' => 'col-md-4',
            'nom' => 'levels_id',
            'label' => 'Niveau',
            'collection' => $levels,
            'error' => 'NiveauMembreError',
          ])
        </div>
          {{-- Adresse, contact personnel et tuteur --}}
        <div class="row mb-2">
          @include('widget.input', [
            'column' => 'col-md-4',
            'nom' => 'adresse',
            'label' => 'Adresse',
            'error' => 'AdresseMembreError',
          ])
          @include('widget.input', [
            'column' => 'col-md-4',
            'type' => 'number',
            'nom' => 'contact_personnel',
            'label' => 'Contact',
            'error' => 'ContactPersonnelMembreError',
          ])
          @include('widget.input', [
            'column' => 'col-md-4',
            'type' => 'number',
            'nom' => 'contact_tuteur',
            'label' => 'Contact Tuteur (Parent)',
            'error' => 'ContactTuteurMembreError',
          ])
        </div>
        {{-- Profession, facebook et Sympathisant --}}
        <div class="row mb-2">
          @include('widget.input', [
            'column' => 'col-md-4',
            'nom' => 'profession',
            'label' => 'Profession',
            'error' => 'ProfessionMembreError',
          ])
          @include('widget.input', [
            'column' => 'col-md-4',
            'nom' => 'facebook',
            'label' => 'Facebook',
            'error' => 'FacebookMembreError',
          ])
          @include('widget.select', [
            'column' => 'col-md-4',
            'nom' => 'sympathisant',
            'label' => 'Sympathisant',
            'collection' => [
              '0' =>'Non',
              '1' =>'Oui'
            ],
            'error' => 'SympathisantMembreError',
          ])
        </div>
        <div class="row mb-2">
          @include('widget.input', [
            'column' => 'col-md-4',
            'nom' => 'etablissement',
            'label' => 'Etablissement',
            'error' => 'EtablissementMembreError',
          ])
          @include('widget.input', [
            'column' => 'col-md-4',
            'type' => 'date',
            'nom' => 'date_inscription',
            'label' => 'Date d\'inscription',
            'error' => 'DateIncriptionMembreError',
          ])
          <div class="col-md-4"></div>
        </div>
      </form>
    </div>
    <div class="card-footer bg-white">
      <div class="d-flex justify-content-end">
        <a href="{{ route('admin.membres.index') }}" type="button" class="btn btn-danger me-2"><i class="fas fa-sign-out-alt fw-bold"></i>&nbsp;Annuler</a>
        <a href="#" type="button" id="btn-save-membre-form-modal" class="btn btn-primary"><i class="fas fa-save fw-bold"></i>&nbsp;Enregistrer</a>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var dateInscriptionField = document.getElementById('date_inscription');
      var today = new Date();
      var formattedDate = today.toISOString().substr(0, 10); // Format 'YYYY-MM-DD'
      dateInscriptionField.value = formattedDate;
    });
    document.getElementById('uploadPhoto').addEventListener('change', function(event) {
      var reader = new FileReader();
      reader.onload = function(){
          var output = document.getElementById('previewImage');
          output.src = reader.result;
      };
      if (event.target.files[0]) {
          reader.readAsDataURL(event.target.files[0]);
      }
    });

    $(document).ready(function(){
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('body').on('change', '#sympathisant', function(){
        let sympathisant = $('#sympathisant').val();
        let axesSelect = $('#axes_id');
        if (sympathisant == '1') {
            axesSelect.prop('disabled', true);
            axesSelect.val('');
        } else {
            axesSelect.prop('disabled', false);
        }
      });

      $('#btn-save-membre-form-modal').click(function() {
        var form = $('#ajaxMembreForm')[0];
        var formData = new FormData(form);
        $('.error-message').html('');

        var button = this;
        var originalContent = button.innerHTML;
        var loadingContent = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> patientez...';

        // Change the button content to show the spinner
        button.innerHTML = loadingContent;
        button.disabled = true;
        var membre_id = $('#membre_id').val();

        $.ajax({
          url: "{{ route('admin.membres.store') }}",
          method: 'POST',
          processData: false,
          contentType: false,
          data: formData,
          success: function(response) {
              if (response) {
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
                 console.log(error);
                  $('#ImageMembreError').html(error.responseJSON.errors.image);
                  $('#NumeroCarteMembreError').html(error.responseJSON.errors.numero_carte);
                  $('#NomMembreError').html(error.responseJSON.errors.nom);
                  $('#PrenomMembreError').html(error.responseJSON.errors.prenom);
                  $('#CinMembreError').html(error.responseJSON.errors.cin);
                  $('#DdnMembreError').html(error.responseJSON.errors.date_de_naissance);
                  $('#LdnMembreError').html(error.responseJSON.errors.lieu_de_naissance);
                  $('#EmailMembreError').html(error.responseJSON.errors.email);
                  $('#AdresseMembreError').html(error.responseJSON.errors.adresse);
                  $('#ContactPersonnelMembreError').html(error.responseJSON.errors.contact_personnel);
                  $('#ProfessionMembreError').html(error.responseJSON.errors.profession);
                  $('#FacebookMembreError').html(error.responseJSON.errors.facebook);
                  $('#DateIncriptionMembreError').html(error.responseJSON.errors.date_inscription);
                  button.innerHTML = originalContent;
                  button.disabled = false;
              }
          }
        });   
      });
    });
  </script>
@endsection

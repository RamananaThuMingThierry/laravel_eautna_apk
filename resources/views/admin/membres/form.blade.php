@extends('admin.admin', ['titre' => $membre->id ? 'Modifier' : 'Nouveau' . ' Membre'])

@section('titre')
  {{ $membre->id ? 'Modifier' : 'Nouveau' }} membre
@endsection

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
    <form id="ajaxMembreForm" method="POST" enctype="multipart/form-data">
      <div class="card-header rounded-0 bg-white">
        <h2 class="text-center text-warning">@yield('titre')</h2>
      </div>
      <div class="card-body bg-white">
        @csrf
        <input type="hidden" name="membre_id" id="membre_id" value="{{ $membre->id ?? '' }}">
        <div class="row mb-2">
          <div class="col-lg-4">
            <div class="d-flex flex-column justify-content-center align-items-center">
              <img src="{{ asset('images/' . ($membre->image != null ? $membre->image : 'img.png')) }}" alt="Pas d'image" class="custom-img" id="previewImage">
              <input type="file" id="uploadPhoto" name="photo" class="form-control rounded-0"/>
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
                'valeur' => $membre->numero_carte,
                'error' => 'NumeroCarteMembreError',
              ])
              @include('widget.input', [
                'nom' => 'cin',
                'type' => 'number',
                'label' => 'Carte d\'Identité National',
                'valeur' => $membre->cin,
                'error' => 'CinMembreError',
              ])
            </div>
              {{-- Nom et Prénom --}}
            <div class="row mb-2">
              @include('widget.input', [
                'nom' => 'nom',
                'label' => 'Nom',
                'valeur' => $membre->nom,
                'error' => 'NomMembreError',
              ])
              @include('widget.input', [
                'nom' => 'prenom',
                'label' => 'Prénom',
                'valeur' => $membre->prenom,
                'error' => 'PrenomMembreError',
              ])
            </div>
            {{-- Date et Lieu de naissance --}}
            <div class="row mb-2">
              @include('widget.input', [
                'nom' => 'date_de_naissance',
                'type' => 'date',
                'label' => 'Date de naissance',
                'valeur' => $membre->date_de_naissance,
                'error' => 'DdnMembreError',
              ])
              @include('widget.input', [
                'nom' => 'lieu_de_naissance',
                'label' => 'Lieu de naissance',
                'valeur' => $membre->lieu_de_naissance,
                'error' => 'LdnMembreError',
              ])
            </div>
            {{-- Adresse e-mail et Genre --}}
            <div class="row mb-2">
              @include('widget.input', [
                'nom' => 'email',
                'type' => 'email',
                'label' => 'Adresse email',
                'valeur' => $membre->email,
                'error' => 'EmailMembreError',
              ])
              @include('widget.select', [
                'nom' => 'genre',
                'label' => 'Genre',
                'collection' => [
                  'homme' =>'Homme',
                  'femme' =>'Femme'
                ],
                'valeur' => $membre->genre,
                'error' => 'GenreMembreError',
              ])
            </div>
              {{-- Axes et Section --}}
              <div class="row mb-2">
              @include('widget.select', [
                'nom' => 'axes_id',
                'label' => 'Axes',
                'collection' => $axes,
                'valeur' => $membre->axes_id,
                'error' => 'AxesMembreError',
              ])
              @include('widget.select', [
                'nom' => 'sections_id',
                'label' => 'Section',
                'collection' => $sections,
                'valeur' => $membre->sections_id,
                'error' => 'SectionMembreError'
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
            'valeur' => $membre->fonctions_id,
            'error' => 'FonctionMembreError',
          ])
          @include('widget.select', [
            'column' => 'col-md-4',
            'nom' => 'filieres_id',
            'label' => 'Filières',
            'collection' => $filieres,
            'valeur' => $membre->filieres_id,
            'error' => 'FiliereMembreError',
            'nullable' => true
          ])
          @include('widget.select', [
            'column' => 'col-md-4',
            'nom' => 'levels_id',
            'label' => 'Niveau',
            'collection' => $levels,
            'valeur' => $membre->levels_id,
            'error' => 'NiveauMembreError',
            'nullable' => true
          ])
        </div>
          {{-- Adresse, contact personnel et tuteur --}}
        <div class="row mb-2">
          @include('widget.input', [
            'column' => 'col-md-4',
            'nom' => 'adresse',
            'label' => 'Adresse',
            'valeur' => $membre->adresse,
            'error' => 'AdresseMembreError',
          ])
          @include('widget.input', [
            'column' => 'col-md-4',
            'type' => 'number',
            'nom' => 'contact_personnel',
            'label' => 'Contact',
            'valeur' => $membre->contact_personnel,
            'error' => 'ContactPersonnelMembreError',
          ])
          @include('widget.input', [
            'column' => 'col-md-4',
            'type' => 'number',
            'nom' => 'contact_tuteur',
            'label' => 'Contact Tuteur (Parent)',
            'valeur' => $membre->contact_tuteur,
            'error' => 'ContactTuteurMembreError',
          ])
        </div>
        {{-- Profession, facebook et Sympathisant --}}
        <div class="row mb-2">
          @include('widget.input', [
            'column' => 'col-md-4',
            'nom' => 'profession',
            'label' => 'Profession',
            'valeur' => $membre->profession,
            'error' => 'ProfessionMembreError',
          ])
          @include('widget.input', [
            'column' => 'col-md-4',
            'nom' => 'facebook',
            'label' => 'Facebook',
            'valeur' => $membre->facebook,
            'error' => 'FacebookMembreError',
          ])
          @include('widget.select', [
            'column' => 'col-md-4',
            'nom' => 'sympathisant',
            'label' => 'Sympathisant',
            'valeur' => $membre->sympathisant,
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
            'valeur' => $membre->etablissement,
            'error' => 'EtablissementMembreError',
          ])
          @include('widget.input', [
            'column' => 'col-md-4',
            'type' => 'date',
            'nom' => 'date_inscription',
            'valeur' => $membre->date_inscription,
            'label' => 'Date d\'inscription',
            'error' => 'DateIncriptionMembreError',
          ])
          <div class="col-md-4"></div>
        </div>
      </div>
      <div class="card-footer bg-white">
        <div class="d-flex justify-content-end">
          <a href="{{ route('admin.membres.index') }}" type="button" class="btn btn-danger me-2"><i class="fas fa-sign-out-alt fw-bold"></i>&nbsp;Annuler</a>
          <a href="#" type="button" id="btn-save-membre-form-modal" class="btn btn-primary">
            @if($membre->id)
              <i class="fas fa-edit fw-bold"></i>&nbsp;Modifier</a>
            @else
              <i class="fas fa-save fw-bold"></i>&nbsp;Enregistrer</a>
            @endif
        </div>
      </div>
    </form>
  </div>
@endsection

@section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var dateInscriptionField = document.getElementById('date_inscription');
      var today = new Date();
      var valeur = dateInscriptionField.val();
      var formattedDate = today.toISOString().substr(0, 10); // Format 'YYYY-MM-DD'
      dateInscriptionField.value = formattedDate;
      if(valeur == null || valeur == ''){

      }
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

    $('#btn-save-membre-form-modal').click(function(e) {
        e.preventDefault(); // Empêche le comportement par défaut du bouton

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
        console.log(membre_id);
        if(membre_id){
          var url = '{{ route("admin.membres.update", ":id") }}';
            url = url.replace(':id', membre_id);
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
                  if (response.success) {
                      Swal.fire({
                          position: "top",
                          title: 'Réussi!',
                          text: response.message,
                          icon: 'success',
                          confirmButtonText: 'OK'
                      });
                      
                      window.location.href="{{ route('admin.membres.index') }}";
                      button.innerHTML = originalContent;
                      button.disabled = false;
                  }
              },
              error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    $('#ImageMembreError').html(errors.photo ? errors.photo[0] : '');
                    $('#NumeroCarteMembreError').html(errors.numero_carte ? errors.numero_carte[0] : '');
                    $('#NomMembreError').html(errors.nom ? errors.nom[0] : '');
                    $('#PrenomMembreError').html(errors.prenom ? errors.prenom[0] : '');
                    $('#CinMembreError').html(errors.cin ? errors.cin[0] : '');
                    $('#DdnMembreError').html(errors.date_de_naissance ? errors.date_de_naissance[0] : '');
                    $('#LdnMembreError').html(errors.lieu_de_naissance ? errors.lieu_de_naissance[0] : '');
                    $('#EmailMembreError').html(errors.email ? errors.email[0] : '');
                    $('#GenreMembreError').html(errors.genre ? errors.genre[0] : '');
                    $('#AdresseMembreError').html(errors.adresse ? errors.adresse[0] : '');
                    $('#ContactPersonnelMembreError').html(errors.contact_personnel ? errors.contact_personnel[0] : '');
                    $('#ContactTuteurMembreError').html(errors.contact_tuteur ? errors.contact_tuteur[0] : '');
                    $('#ProfessionMembreError').html(errors.profession ? errors.profession[0] : '');
                    $('#FacebookMembreError').html(errors.facebook ? errors.facebook[0] : '');
                    $('#EtablissementMembreError').html(errors.etablissement ? errors.etablissement[0] : '');
                    $('#AxesMembreError').html(errors.axes_id ? errors.axes_id[0] : '');
                    $('#SectionMembreError').html(errors.sections_id ? errors.sections_id[0] : '');
                    $('#FonctionMembreError').html(errors.fonctions_id ? errors.fonctions_id[0] : '');
                    $('#FiliereMembreError').html(errors.filieres_id ? errors.filieres_id[0] : '');
                    $('#NiveauMembreError').html(errors.levels_id ? errors.levels_id[0] : '');
                    $('#DateIncriptionMembreError').html(errors.date_inscription ? errors.date_inscription[0] : '');
                } else {
                    console.log("Une erreur inconnue s'est produite.");
                }
                button.innerHTML = originalContent;
                button.disabled = false;
            }
            });
        }else{
          $.ajax({
            url: "{{ route('admin.membres.store') }}",
            method: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            success: function(response) {
                Swal.fire({
                    position: "top",
                    title: 'Réussi!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                // Clear the form fields
                $('#ajaxMembreForm')[0].reset();

                // Reset the image preview
                $('#previewImage').attr("src", "{{ asset('images/img.png') }}");
                // Recharge la table ou autre action après le succès
                location.reload();
                button.innerHTML = originalContent;
                button.disabled = false;
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    $('#ImageMembreError').html(errors.photo ? errors.photo[0] : '');
                    $('#NumeroCarteMembreError').html(errors.numero_carte ? errors.numero_carte[0] : '');
                    $('#NomMembreError').html(errors.nom ? errors.nom[0] : '');
                    $('#PrenomMembreError').html(errors.prenom ? errors.prenom[0] : '');
                    $('#CinMembreError').html(errors.cin ? errors.cin[0] : '');
                    $('#DdnMembreError').html(errors.date_de_naissance ? errors.date_de_naissance[0] : '');
                    $('#LdnMembreError').html(errors.lieu_de_naissance ? errors.lieu_de_naissance[0] : '');
                    $('#EmailMembreError').html(errors.email ? errors.email[0] : '');
                    $('#GenreMembreError').html(errors.genre ? errors.genre[0] : '');
                    $('#AdresseMembreError').html(errors.adresse ? errors.adresse[0] : '');
                    $('#ContactPersonnelMembreError').html(errors.contact_personnel ? errors.contact_personnel[0] : '');
                    $('#ContactTuteurMembreError').html(errors.contact_tuteur ? errors.contact_tuteur[0] : '');
                    $('#ProfessionMembreError').html(errors.profession ? errors.profession[0] : '');
                    $('#FacebookMembreError').html(errors.facebook ? errors.facebook[0] : '');
                    $('#EtablissementMembreError').html(errors.etablissement ? errors.etablissement[0] : '');
                    $('#AxesMembreError').html(errors.axes_id ? errors.axes_id[0] : '');
                    $('#SectionMembreError').html(errors.sections_id ? errors.sections_id[0] : '');
                    $('#FonctionMembreError').html(errors.fonctions_id ? errors.fonctions_id[0] : '');
                    $('#FiliereMembreError').html(errors.filieres_id ? errors.filieres_id[0] : '');
                    $('#NiveauMembreError').html(errors.levels_id ? errors.levels_id[0] : '');
                    $('#DateIncriptionMembreError').html(errors.date_inscription ? errors.date_inscription[0] : '');
                } else {
                    console.log("Une erreur inconnue s'est produite.");
                }
                button.innerHTML = originalContent;
                button.disabled = false;
            }
          });
        }
    });


    });
  </script>
@endsection

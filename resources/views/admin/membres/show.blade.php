@extends('admin.admin', ['titre' => 'Afficher un membre'])

@section('titre', 'Afficher un membre')

@section('contenu')
<div class="row my-3">
    <div class="card rounded-0 shadow-sm p-2">
        <div class="card-header bg-white">
            <h3 class="text-warning text-center">Détails du Membre</h3>
        </div>
        <div class="card-body">
          <div class="row p-2">
            <div class="col-lg-2 col-md-12">
              <div class="card rounded-0 p-3 shadow-sm rounded-0">
                <div class="card-body d-flex align-items-center justify-content-center">
                  <img src="{{ asset('images/' . ($membre->image ? $membre->image : 'img.png')) }}" alt="Image" class="w-100 img-fluid">
                </div>
              </div>
            </div>
            <div class="col-lg-5 col-md-12">
              <div class="card rounded-0 p-3 shadow-0 border-0">
                <div class="card-body">
                  @include('widget.info',[
                    'label' => 'Numéro carte',
                    'valeur' => $membre->numero_carte
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Nom',
                    'valeur' => $membre->nom
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Prénom',
                    'valeur' => $membre->prenom
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Date de naissance',
                    'valeur' => $membre->date_de_naissance
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Lieu de naissance',
                    'valeur' => $membre->lieu_de_naissance
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Genre',
                    'valeur' => $membre->genre == "homme" ? "HOMME":"FEMME"
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Carte d\'identité National',
                    'valeur' => $membre->cin
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Adresse e-mail',
                    'valeur' => $membre->email
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Téléphone',
                    'valeur' => $membre->contact_personnel
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Téléphone (Parent)',
                    'valeur' => $membre->contact_tuteur
                  ])
                </div>
              </div>
            </div>
            <div class="col-lg-5 col-md-12">
              <div class="card rounded-0 p-3 shadow-0 border-0">
                <div class="card-body">
                  @include('widget.info',[
                    'label' => 'Axes',
                    'valeur' => $membre->axes->nom_axes
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Sections',
                    'valeur' => $membre->section->nom_sections
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Adresse',
                    'valeur' => $membre->adresse
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Fonction',
                    'valeur' => $membre->fonction->nom_fonctions
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Filière',
                    'valeur' => $membre->filiere->nom_filieres
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Niveau',
                    'valeur' => $membre->level->nom_niveau
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Etablissement',
                    'valeur' => $membre->etablissement
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Facebook',
                    'valeur' => $membre->facebook
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Sympathisant',
                    'valeur' => $membre->sympathisant == 0 ? 'NON' : 'OUI'
                  ])
                  <hr>
                  @include('widget.info',[
                    'label' => 'Date d\'inscription',
                    'valeur' => $membre->date_inscription
                  ])
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="pt-3 card-footer bg-white d-flex justify-content-end align-items-center">
          <a href="{{ route('admin.membres.index') }}" class="btn btn-danger"><i class="fas fa-sign-out-alt fw-bold"></i>&nbsp;Retour</a>
        </div>
    </div>
</div>
@endsection

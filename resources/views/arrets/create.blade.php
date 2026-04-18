@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">

        {{-- 🎨 STYLES --}}
        <style>
            .titre {
                text-align: center;
                background-color: rgb(80, 98, 216);
                border-radius: 10px;
                border-left: 6px solid #f4823c;
                border-right: 6px solid #f4823c;
                padding: 10px 0;
                margin-bottom: 30px;
            }

            .titre h2 {
                color: white;
                font-weight: bold;
                font-family: Arial, Helvetica, sans-serif;
            }

            .card {
                border-top: 4px solid rgb(80, 98, 216);
                border-bottom: 10px solid #f4823c;
            }

            .dataTables_filter input {
                border: 3px solid #f4823c;
                border-radius: 15px;
                padding: 6px 10px;
            }
        </style>

        {{-- 🟦 TITRE --}}
        <div class="titre">
            <h2>GESTION DES ARRÊTS</h2>
        </div>

        {{-- 📦 CARD --}}
        <div class="card comman-shadow">
            <div class="card-body">

                {{-- ➕ BOUTON AJOUT --}}
                <div class="d-flex justify-content-end mb-3">
                    @can('arret-ajouter')
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterArretModal">
                        <i class="fas fa-plus"></i> Ajouter un arrêt
                    </button>
                    @endcan
                </div>

                {{-- ✅ MESSAGE SUCCESS --}}
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                {{-- 📊 TABLE --}}
                <table id="example1" class="table table-bordered table-striped text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Ligne</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Ordre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($arrets as $arret)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $arret->nom }}</td>
                            <td>{{ $arret->ligne->nom ?? '-' }}</td>
                            <td>{{ $arret->latitude }}</td>
                            <td>{{ $arret->longitude }}</td>
                            <td>{{ $arret->ordre }}</td>
                            <td>
                                <a href="{{ route('arrets.edit', $arret->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('arrets.destroy', $arret->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Supprimer cet arrêt ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

{{-- 🪟 MODAL AJOUT ARRÊT --}}
<div class="modal fade" id="ajouterArretModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:15px;">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-map-marker-alt"></i> Ajouter un arrêt
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light">
                <form action="{{ route('arrets.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="fw-bold">Ligne</label>
                            <select name="ligne_id" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($lignes as $ligne)
                                <option value="{{ $ligne->id }}">{{ $ligne->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Nom de l’arrêt</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Latitude</label>
                            <input type="text" name="latitude" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Longitude</label>
                            <input type="text" name="longitude" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Ordre</label>
                            <input type="number" name="ordre" class="form-control">
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- 📜 DATATABLE --}}
@section('script')
<script>
$(function () {
    $('#example1').DataTable({
        language: {
            search: "🔍 Rechercher :",
            lengthMenu: "Afficher _MENU_ lignes",
            zeroRecords: "Aucun résultat",
            info: "Page _PAGE_ / _PAGES_",
        }
    });
});
</script>
@endsection

@endsection

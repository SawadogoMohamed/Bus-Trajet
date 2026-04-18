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
            <h2>GESTION DES BUS</h2>
        </div>

        {{-- 📦 CARD --}}
        <div class="card comman-shadow">
            <div class="card-body">

                {{-- ➕ BOUTON AJOUT --}}
                <div class="d-flex justify-content-end mb-3">
                    @can('bus-ajouter')
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterBusModal">
                        <i class="fas fa-plus"></i> Ajouter un bus
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
                            <th>Ligne</th>
                            <th>Numéro du bus</th>
                            <th>État</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($buses as $bus)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $bus->ligne->nom ?? '-' }}</td>
                            <td>{{ $bus->numero_bus }}</td>
                            <td>
                                <span class="badge {{ $bus->etat == 'actif' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($bus->etat) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('buses.edit', $bus->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('buses.destroy', $bus->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Supprimer ce bus ?')">
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

{{-- 🪟 MODAL AJOUT BUS --}}
<div class="modal fade" id="ajouterBusModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:15px;">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-bus"></i> Ajouter un bus
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light">
                <form action="{{ route('buses.store') }}" method="POST">
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
                            <label class="fw-bold">Numéro du bus</label>
                            <input type="text" name="numero_bus" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">État</label>
                            <select name="etat" class="form-select">
                                <option value="actif">Actif</option>
                                <option value="hors_service">Hors service</option>
                            </select>
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

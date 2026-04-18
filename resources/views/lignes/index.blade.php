@extends('layouts.master')
@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">

        {{-- 🎨 STYLE COULEURS UNIQUEMENT --}}
        <style>
            :root {
                --green: #009640;
                --green-dark: #007c34;
                --yellow: #FFD100;
                --blue: #5062d8;
                --gray-bg: #f8f9fa;
            }

            body {
                background: var(--gray-bg);
            }

            .page-title {
                color: var(--green);
                font-weight: 700;
            }

            .card {
                border-top: 4px solid var(--green);
                border-bottom: 5px solid var(--yellow);
                border-radius: 12px;
            }

            .table thead {
                background-color: var(--green);
                color: #fff;
            }

            .btn-primary {
                background-color: var(--green);
                border-color: var(--green);
            }

            .btn-primary:hover {
                background-color: var(--green-dark);
            }

            .btn-warning {
                background-color: var(--yellow);
                border-color: var(--yellow);
                color: #000;
            }

            .btn-warning:hover {
                background-color: #e6bd00;
            }

            .btn-danger {
                background-color: #dc3545;
            }

            .dataTables_filter input {
                border: 2px solid var(--green);
                border-radius: 12px;
                padding: 6px 10px;
            }

            .alert-success {
                background-color: #e9f7ef;
                border-left: 5px solid var(--green);
                color: #155724;
            }

            /* Modal */
            .modal-header {
                background: linear-gradient(90deg, var(--green), var(--green-dark));
                color: #fff;
            }

            .modal-content {
                border-radius: 15px;
            }

            /* Pagination */
            .page-item.active .page-link {
                background-color: var(--green);
                border-color: var(--green);
            }

            .page-link {
                color: var(--green);
            }

            .page-link:hover {
                background-color: #e9f7ef;
            }
        </style>

        {{-- 📄 CONTENU --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <div class="page-header mb-4">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">Liste des lignes</h3>
                                </div>

                                <div class="col-auto text-end">
                                    @can('departement-ajouter')
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterLigneModal">
                                        <i class="fas fa-plus"></i> Ajouter une ligne
                                    </button>
                                    @endcan
                                </div>
                            </div>
                        </div>

                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                        @endif

                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="text-center">
                                <tr>
                                    <th>Ville</th>
                                    <th>Nom</th>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lignes as $ligne)
                                <tr>
                                    <td>{{ $ligne->ville->nom }}</td>
                                    <td>{{ $ligne->nom }}</td>
                                    <td>{{ $ligne->code }}</td>
                                    <td>{{ $ligne->description }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('lignes.edit',$ligne->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>

                                        <form action="{{ route('lignes.destroy',$ligne->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Supprimer cette ligne ?')">
                                                <i class="fas fa-trash"></i> Supprimer
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

    </div>
</div>

{{-- 📊 DATATABLE --}}
@section('script')
<script>
$(document).ready(function() {
    $('#example1').DataTable({
        language: {
            search: "🔍 Rechercher :",
            lengthMenu: "Afficher _MENU_ lignes",
            zeroRecords: "Aucun résultat",
            info: "Page _PAGE_ sur _PAGES_",
        }
    });
});
</script>
@endsection

{{-- 🟢 MODAL AJOUT --}}
<div class="modal fade" id="ajouterLigneModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-route me-2"></i> Ajouter une ligne
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('lignes.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-success">Ville</label>
                            <select name="ville_id" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($villes as $ville)
                                <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-success">Nom</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-success">Code</label>
                            <input type="text" name="code" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-success">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

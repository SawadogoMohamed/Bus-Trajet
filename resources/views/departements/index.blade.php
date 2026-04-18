@extends('layouts.master')
@section('content')

    <div class="page-wrapper">
        <div class="content container-fluid">
            <style>
                .titre {
                    text-align: center;
                    background-color: rgb(80, 98, 216);
                    border-radius: 10px;
                    border: 1px solid black;

                }

                .titre h2 {
                    color: rgb(255, 255, 255);
                    padding: 8px;
                    font-family: Arial, Helvetica, sans-serif
                }

                .titre {
                    border-left: 6px solid #f4823c;
                    border-right: 6px solid #f4823c;
                }
            </style>

            <div class="col-lg-12 margin-tb">
                <div class="titre">
                    <h2>GESTION DES DEPARTEMENTS</h2>
                </div>
            </div>

            <br><br>


            <br>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table comman-shadow"
                        style="border-bottom: 10px solid #f4823c; border-top: 4px solid rgb(80, 98, 216);">
                        <div class="card-body">

                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Liste des departements</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">

                                        @can('departement-ajouter')
                                            <a href="{{ route('departements.create') }}" class="btn btn-primary"><i
                                                    class="fas fa-plus"></i> Ajouter departement</a>
                                        @endcan

                                    </div>
                                </div>
                            </div>

                            <hr style="border: 2px solid black;">

                            <div class="table-responsive">
                                <!--  -------------   debut  message de retour  ------------------------------- -->
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <p style="font-size: 18px;">{{ $message }}</p>
                                    </div>
                                @endif
                                <!--  -------------   fin  message de retour  ------------------------------- -->


                                <table id="example1"
                                    class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">

                                    <thead class="student-thread">
                                        <tr>
                                            <th>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </th>
                                            <th style="font-size: 18px; color: black;">N°</th>
                                            <th style="font-size: 18px; color: black;">Nom du departement</th>
                                            <th style="font-size: 18px; color: black;">Description</th>
                                            <th style="font-size: 18px; color: black;">Fichier PDF</th>
                                            @can('role-list')
                                                <th style="font-size: 18px; color: black;">Enregistrer par</th>
                                                <th style="font-size: 18px; color: black;">Modifier par</th>
                                            @endcan
                                            <th class="text-end" style="font-size: 18px; color: black;">Action</th>
                                        </tr>
                                    </thead>


                                    <tbody id="Table">

                                        @foreach ($departements as $departement)
                                            <tr>
                                                <td>
                                                    <div class="form-check check-tables">
                                                        <input class="form-check-input" type="checkbox" value="something">
                                                    </div>
                                                </td>
                                                <td style="font-size: 16px; color: black;">{{ ++$i }}</td>
                                                <td style="font-size: 16px; color: black;">{{ $departement->nom }}</td>
                                                <td style="font-size: 16px; color: black;">{{ $departement->description }}
                                                </td>
                                                <td style="font-size: 16px; color: black;">
                                                    @if ($departement->pdf_path)
                                                        <a href="{{ asset('storage/' . $departement->pdf_path) }}" target="_blank" class="badge badge-success">
                                                            Voir le PDF
                                                        </a>
                                                    @else
                                                        Aucun fichier PDF
                                                    @endif
                                                </td>
                                                @can('role-list')
                                                    <td style="font-size: 16px; color: black;">
                                                        {{ $departement->enregistrer }} le
                                                        {{ $departement->created_at }}
                                                    </td>
                                                    @if ($departement->modifier == '')
                                                        <td style="font-size: 16px; color: black;">
                                                            {{ $departement->modifier }}
                                                        </td>
                                                    @else
                                                        <td style="font-size: 16px; color: black;">
                                                            {{ $departement->modifier }} le
                                                            {{ $departement->updated_at }}
                                                        </td>
                                                    @endif
                                                @endcan
                                                <td class="text-end">
                                                    <div class="actions" style="display: flex;">
                                                        <form
                                                            action="{{ route('departements.destroy', $departement->id) }}"
                                                            method="POST" class="actions">

                                                            <a href="{{ route('departements.show', $departement->id) }}"
                                                                class="btn btn-sm bg-danger-light">
                                                                <i
                                                                    style="font-size: 16px; color: black;"class="fab fa-phabricator"></i>
                                                            </a>

                                                            @can('departement-modifier')
                                                                <a href="{{ route('departements.edit', $departement->id) }}"
                                                                    class="btn btn-sm bg-danger-light student_delete">
                                                                    <i
                                                                        style="font-size: 16px; color: black;"class="feather-edit"></i>
                                                                </a>
                                                            @endcan

                                                            @csrf
                                                            @method('DELETE')
                                                            @can('departement-supprimer')
                                                                <button type="submit" class="btn btn-sm bg-danger-light">
                                                                    <i
                                                                        style="font-size: 16px; color: black;"class="feather-trash-2 me-1"></i>
                                                                </button>
                                                            @endcan

                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                                <div id="pagination"> {!! $departements->links() !!}</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Personnalisation du style de la barre de recherche */
        .dataTables_filter input[type="search"] {
            border: 3px solid #f4823c;
            border-radius: 15px;
            /* Bordure de 2 pixels avec la couleur de votre choix */
            color: #000000;
            /* Couleur du texte */
            font-family: Arial, sans-serif;
            /* Police de caractères */
            font-size: 16px;
            /* Taille de la police */
            /* Ajoutez d'autres styles selon vos besoins */
        }
    </style>

    {{-- model student delete --}}


    <div class="modal fade contentmodal" id="supp" tabindex="QX" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <form action="" method="POST" class="actions">
                    <div class="modal-body">
                        <div class="delete-wrap text-center">
                            <div class="del-icon">
                                <i class="feather-x-circle"></i>
                            </div>

                            <h2>Vous voulez vraiment Supprimer? </h2>
                            <div class="submit-section">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-success me-2">OUI</button>
                                <a class="btn btn-danger" data-bs-dismiss="modal">NON</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@section('script')
    <script>
        $(document).ready(function() {
            $('#example1').DataTable({
                dom: 'Bfrtip',
                destroy: true,
                paging: false,
                paging: false,
                "searching": true,
                "search": {
                    "caseInsensitive": true, // Recherche insensible à la casse
                    "regex": true, // Utilise des expressions régulières dans la recherche
                },
                language: {
                    search: "RECHERCHER :" // Remplace "Search :" par "Rechercher :"
                },

                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel" style="font-size:20px;color:green"> Excel</i>',
                        title: 'LISTE DES DEPARTEMENTS',
                        className: 'display:none',
                        exportOptions: {
                            columns: [1, 2, 3] // Inclure les colonnes 1, 2, et 3 dans le excel
                        },
                    },


                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf" style="font-size:20px;color:red"> Pdf</i>',
                        title: 'LA LISTE DES DEPARTEMENTS',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [1, 2, 3] // Inclure les colonnes 1, 2, et 3 dans le PDF
                        },

                    },


                    {
                        extend: 'print',
                        text: '<i class="fas fa-file-powerpoint" style="font-size:20px;color:blue"> Imprimer</i>',
                        title: 'LA LISTE DES DEPARTEMENTS',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [1, 2, 3] // Inclure les colonnes 1, 2, et 3 dans le imprimer
                        },
                    },

                ]
            });
        });
    </script>

    {{-- delete js --}}
    <script>
        $(document).on('click', '.student_delete', function() {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
            $('.e_avatar').val(_this.find('.avatar').text());
        });
    </script>
@endsection

@endsection

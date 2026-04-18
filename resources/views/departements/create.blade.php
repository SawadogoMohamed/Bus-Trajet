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
                    font-family: Arial, Helvetica, sans-serif;

                }

                .mote {
                    color: black;
                    background-color: #f4823c;
                    border: 2px solid black;
                    transition: all ease-in-out 0.3s;
                    font-size: 18px;
                    border-radius: 12px;
                }

                .mote:hover {
                    color: rgb(255, 255, 255);
                    background-color: rgb(80, 98, 216);
                    border: 2px solid #f4823c;
                    border-radius: 12px;

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

            @can('departement-liste')
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right" style="text-align: center; font-family: Arial, Helvetica, sans-serif;">
                        <a class="mote btn" href="{{ route('departements.index') }}">-- Liste des departements --</a>
                    </div>
                </div>
            @endcan

            <br>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow"
                        style="border-bottom: 10px solid #f4823c; border-top: 4px solid rgb(80, 98, 216);">
                        <div class="card-body">

                            <!--  -------------   debut  message de retour  ------------------------------- -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong style="font-size: 18px;">Erreur!</strong>

                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li style="font-size: 18px;">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!--  -------------   fin  message de retour  ------------------------------- -->
                            <!--  -------------   debut  message de retour  ------------------------------- -->
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            <!--  -------------   fin  message de retour  ------------------------------- -->


                            <form action="{{ route('departements.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-12">
                                        <h3 class="form-title student-info">Formulaire d'enregistrement des departements
                                        </h3>
                                    </div>

                                    <hr style="border: 1px solid black;"><br>

                                    <div class="col-12 col-sm-6">
                                        <div class="form-group local-forms">
                                            <strong style="font-size: 18px; color: black;">Nom du departement <span
                                                    class="login-danger">*</span></strong>
                                            <input type="text" name="nom" class="form-control"
                                                placeholder="Nom du depatement" required>

                                        </div>
                                    </div>


                                    <div class="col-12 col-sm-6">
                                        <div class="form-group local-forms">
                                            <strong style="font-size: 18px; color: black;">Description </strong>
                                            <textarea class="form-control" style="height:100px" name="description" placeholder="Description"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="form-group local-forms">
                                            <strong style="font-size: 18px; color: black;">Télécharger un fichier PDF</strong>
                                            <input type="file" name="pdf_file" class="form-control-file" accept=".pdf">
                                        </div>
                                    </div>

                                    {{-- champ de recuperation du nom de l'utilisateur qui effectue le traitement --}}
                                    <div class="col-12 col-sm-6" style="display: none;">
                                        <div class="form-group local-forms">
                                            <strong style="font-size: 18px; color: black;">Nom utilisateur<span
                                                    class="login-danger">*</span></strong>
                                            <input type="text" class="form-control" name="enregistrer"
                                                value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                    </div>



                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

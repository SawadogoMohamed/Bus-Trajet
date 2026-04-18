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
                .titre{
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
            <div class="col-lg-12 margin-tb">
                <div class="pull-right" style="text-align: center; font-family: Arial, Helvetica, sans-serif;">
                    <a class="mote btn" href="{{ route('departements.index') }}">-- Liste des departements --</a>
                </div>
            </div>
            <br>


            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow" style="border-bottom: 10px solid #f4823c; border-top: 4px solid rgb(80, 98, 216);">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    <div class="col-12">
                                        <h3 class="form-title student-info">Information du departement</h3>
                                    </div>
                                </div>

                                <hr style="border: 1px solid black;"><br>

                                <div class="col-xs-12 col-sm-12 col-md-12" style="font-size: 22px;">
                                    <div class="form-group local-forms">
                                        <strong style="color: rgb(0, 0, 0)"><u>Nom du departement</u>:</strong>
                                        {{ $departement->nom }}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12" style="font-size: 22px;">
                                    <div class="form-group local-forms">
                                        <strong style="color: rgb(0, 0, 0)"><u>Description</u>:</strong>
                                        {{ $departement->description }}

                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12" style="font-size: 22px;">
                                    <div class="form-group local-forms">
                                        <strong style="color: rgb(0, 0, 0)"><u>Le pdf</u>:</strong>
                                        @if ($departement->pdf_path)
                                        <a href="{{ asset('storage/' . $departement->pdf_path) }}" target="_blank" class="badge badge-success">
                                            Voir le PDF
                                        </a>
                                    @else
                                        Aucun fichier PDF
                                    @endif

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

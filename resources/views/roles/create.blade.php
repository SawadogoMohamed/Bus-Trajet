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

                /* Styles pour la case cochée */
                .green-checkbox input[type="checkbox"] {
                    display: none;
                    /* Masque la case à cocher par défaut */
                }

                .green-checkbox input[type="checkbox"]+label {
                    position: relative;
                    padding-left: 25px;
                    /* Espace pour la case à cocher personnalisée */
                }

                .green-checkbox input[type="checkbox"]+label::before {
                    content: "";
                    display: inline-block;
                    width: 15px;
                    /* Largeur de la case à cocher personnalisée */
                    height: 15px;
                    /* Hauteur de la case à cocher personnalisée */
                    border: 1px solid rgb(0, 0, 0);
                    /* Couleur de la bordure */
                    background-color: white;
                    /* Couleur de fond de la case à cocher */
                    position: absolute;
                    left: 0;
                    top: 2px;
                }

                /* Styles pour la case cochée */
                .green-checkbox input[type="checkbox"]:checked+label::before {
                    background-color: #f4823c;
                    /* Couleur de fond verte lorsque la case est cochée */
                }
            </style>

            <div class="col-lg-12 margin-tb">
                <div class="titre">
                    <h2>GESTION DES ROLES</h2>
                </div>
            </div>

            <br><br>
            <div class="col-lg-12 margin-tb">
                <div class="pull-right" style="text-align: center; font-family: Arial, Helvetica, sans-serif;">
                    <a class="mote btn" href="{{ route('roles.index') }}"> Liste des roles</a>
                </div>
            </div>
            <br>

            <div class="page-header">
                <div class="col-sm-12">
                    <div class="card comman-shadow"
                        style="border-bottom: 10px solid #f4823c; border-top: 4px solid rgb(80, 98, 216);">
                        <div class="card-body">

                            <!--  -------------   debut  message de retour  ------------------------------- -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Erreur!</strong> Veuillez remplir tous les champs S'il vous plait.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
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



                            {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <h4>Nom du role</h4>
                                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                                    </div>
                                </div>





                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <h4>Permissions</h4>
                                    <br />

                                    @php
                                        $count = 0;
                                        $groupedPermissions = array_chunk($permission->toArray(), 4); // Divise les autorisations en groupes de 4
                                        $groupTitles = ['Gestion des roles',  'Gestion des departements','Gestion des employés']; // Définissez ici les titres des groupes
                                    @endphp

                                    <table class="table">
                                        <tbody>
                                            @foreach ($groupedPermissions as $key => $group)
                                                <tr>
                                                    <td colspan="4">
                                                        @if (isset($groupTitles[$key]))
                                                            <h4><u>{{ $groupTitles[$key] }}</u></h4>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    @foreach ($group as $value)
                                                        <td class="green-checkbox">
                                                            <input type="checkbox" id="checkbox{{ $value['id'] }}"
                                                                name="permission[]" value="{{ $value['id'] }}"
                                                                class="name">
                                                            <label
                                                                for="checkbox{{ $value['id'] }}">{{ $value['name'] }}</label>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>




                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

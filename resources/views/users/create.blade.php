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

                .mote{
                    color: black;
                    background-color:#f4823c;
                    border: 2px solid black;
                    transition: all ease-in-out 0.3s;
                    font-size: 18px;
                    border-radius: 12px;

                }
                .mote:hover{
                    color: rgb(255, 255, 255);
                    background-color:rgb(80, 98, 216);
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
                    <h2>GESTION DES UTILISATEURS</h2>
                </div>
            </div>

            <br><br>
            <div class="col-lg-12 margin-tb">
                <div class="pull-right" style="text-align: center; font-family: Arial, Helvetica, sans-serif;">
                    <a class="mote btn" href="{{ route('users.index') }}">-- Liste des utilisateurs --</a>
                </div>
            </div>
            <br>

            <div class="col-sm-12">
                <div class="card comman-shadow" style="border-bottom: 10px solid #f4823c; border-top: 4px solid rgb(80, 98, 216);">
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




                        {!! Form::open(['route' => 'users.store', 'method' => 'POST']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Nom & Prénom</strong>
                                    {!! Form::text('name', null, ['placeholder' => 'nom & prenom', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>E-mail</strong>
                                    {!! Form::text('email', null, ['placeholder' => 'e-mail', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Mot de passe (mot de passe par defaut:kafyka@2023)</strong>
                                    <input type="password" class="form-control" value="kafyka@2023" name="password" >

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Confirmer Mote de passe (mot de passe par defaut:kafyka@2023)</strong>
                                    <input type="password" class="form-control" value="kafyka@2023" name="confirm-password">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Selectionner le Roles</strong>
                                    {!! Form::select('roles[]', $roles, [], ['class' => 'form-control', 'multiple']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 ">
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

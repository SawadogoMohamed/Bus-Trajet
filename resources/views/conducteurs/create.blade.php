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
                <a class="mote btn" href="">-- Liste des departements --</a>
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


                        <h2>Ajouter un conducteur</h2>
                        <form action="{{ route('conducteurs.store') }}" method="POST">
                            @csrf
                            <div class="mb-3"><label>Nom</label><input type="text" name="nomPrenom" class="form-control" required></div>
                            <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                            <div class="mb-3"><label>Téléphone</label><input type="text" name="telephone" class="form-control" required></div>
                            <div class="mb-3"><label>Mot de passe</label><input type="password" name="password" class="form-control" required></div>
                            <div class="mb-3"><label>Bus</label>
                                <select name="bus_id" class="form-control">
                                    @foreach($buses as $bus)
                                    <option value="{{ $bus->id }}">{{ $bus->numero_bus }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-success">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
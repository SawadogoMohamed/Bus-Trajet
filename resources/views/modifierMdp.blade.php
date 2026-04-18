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
                border-left: 6px solid #f4823c;
                border-right: 6px solid #f4823c;
            }

            .titre h2 {
                color: #fff;
                padding: 10px;
                font-family: Arial, Helvetica, sans-serif;
                margin: 0;
            }
        </style>

        <!-- Titre -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="titre">
                    <h2>MODIFICATION DU MOT DE PASSE</h2>
                </div>
            </div>
        </div>

        <!-- Carte -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card comman-shadow"
                    style="border-bottom: 8px solid #f4823c; border-top: 4px solid rgb(80, 98, 216);">
                    
                    <div class="card-body">

                        <!-- Erreurs -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Erreur :</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Succès -->
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                {{ $message }}
                            </div>
                        @endif

                        <!-- Formulaire -->
                        <form action="/changepassword" method="POST">
                            @csrf

                            <div class="mb-3">
                                {!! Form::label('current_password', 'Ancien mot de passe', ['class' => 'form-label']) !!}
                                {!! Form::password('current_password', ['class' => 'form-control']) !!}
                            </div>

                            <div class="mb-3">
                                {!! Form::label('new_password', 'Nouveau mot de passe', ['class' => 'form-label']) !!}
                                {!! Form::password('new_password', ['class' => 'form-control']) !!}
                            </div>

                            <div class="mb-4">
                                {!! Form::label('new_password_confirmation', 'Confirmer le nouveau mot de passe', ['class' => 'form-label']) !!}
                                {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
                            </div>

                            <div class="d-grid">
                                {!! Form::submit('Modifier le mot de passe', ['class' => 'btn btn-primary btn-lg']) !!}
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

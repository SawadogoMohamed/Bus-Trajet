@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="col-lg-12 margin-tb">
            <div class="titre">
                <h2>AJOUTER UNE POSITION GPS</h2>
            </div>
        </div>

        <br>

        <div class="card comman-shadow">
            <div class="card-body">

                <form action="{{ route('positions.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Bus</label>
                        <select name="bus_id" class="form-control" required>
                            @foreach($buses as $b)
                                <option value="{{ $b->id }}">{{ $b->numero_bus }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Latitude</label>
                        <input type="text" name="latitude" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Longitude</label>
                        <input type="text" name="longitude" class="form-control" required>
                    </div>

                    <button class="btn btn-success">Enregistrer</button>
                    <a href="{{ route('positions.index') }}" class="btn btn-secondary">Retour</a>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection

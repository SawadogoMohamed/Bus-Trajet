@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="col-lg-12 margin-tb">
            <div class="titre">
                <h2>GESTION DES POSITIONS GPS</h2>
            </div>
        </div>

        <br>

        <div class="card card-table comman-shadow">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Liste des positions</h3>
                    <a href="{{ route('positions.create') }}" class="btn btn-primary">
                        + Nouvelle position
                    </a>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bus</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($positions as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->bus->numero_bus ?? '-' }}</td>
                            <td>{{ $p->latitude }}</td>
                            <td>{{ $p->longitude }}</td>
                            <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>
@endsection

@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">

        <style>
            :root {
                --sotraco-green: #009640;
                --sotraco-yellow: #FFD100;
                --sotraco-bg: #f6faf7;
            }

            body {
                background: var(--sotraco-bg);
                font-family: 'Poppins', sans-serif;
            }

            /* ===== HERO ===== */
            .hero {
                background: linear-gradient(135deg, var(--sotraco-green), #066b2e);
                color: #fff;
                text-align: center;
                padding: 40px 15px;
                border-radius: 0 0 28px 28px;
            }

            .hero h1 {
                color: var(--sotraco-yellow);
                font-weight: 700;
            }

            .hero-logo {
                width: 110px;
                margin-bottom: 10px;
            }

            /* ===== STATS ===== */
            .info-section {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 20px;
                margin-top: -40px;
                margin-bottom: 30px;
            }

            .info-card {
                background: #fff;
                border-radius: 16px;
                padding: 20px 15px;
                text-align: center;
                box-shadow: 0 8px 18px rgba(0,0,0,.08);
                border-top: 4px solid var(--sotraco-green);
                transition: all .25s ease;
            }

            .info-card h3 {
                font-weight: 700;
                margin-bottom: 4px;
            }

            .info-card p {
                margin: 0;
                font-size: 14px;
                color: #6c757d;
            }

            .info-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 25px rgba(0,0,0,.12);
            }

            .info-card.primary {
                background: var(--sotraco-green);
                color: #fff;
                border-top: none;
            }

            /* ===== FORM ===== */
            .form-control {
                border-radius: 12px;
                border: 1px solid var(--sotraco-green);
            }

            #infosTrajet {
                font-weight: 600;
                text-align: center;
                margin-top: 12px;
                color: var(--sotraco-green);
            }

            /* ===== MAP ===== */
            #map {
                height: 65vh;
                border-radius: 16px;
                box-shadow: 0 10px 25px rgba(0,0,0,.12);
            }
        </style>

        <!-- HERO -->
        <div class="hero">
            <img src="{{ asset('images/logo_sotraco.jpeg') }}" class="hero-logo" alt="SOTRACO">
            <h1>Suivi des bus en temps réel</h1>
            <p>Transport urbain intelligent — Burkina Faso</p>
        </div>

        <!-- STATS -->
        <div class="container">
            <div class="info-section">
                <div class="info-card">
                    <h3>{{ count($villes) }}</h3>
                    <p>Villes</p>
                </div>

                <div class="info-card">
                    <h3 id="nbLignes">—</h3>
                    <p>Lignes</p>
                </div>

                <div class="info-card">
                    <h3 id="nbBus">—</h3>
                    <p>Bus actifs</p>
                </div>

                <div class="info-card primary">
                    <h3 id="visiteurs">—</h3>
                    <p>Visiteurs</p>
                </div>
            </div>
        </div>

        <!-- FORM -->
        <div class="container mt-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold">Ville</label>
                        <select id="ville" class="form-control">
                            <option value="">-- Sélectionner --</option>
                            @foreach($villes as $ville)
                                <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="fw-bold">Ligne</label>
                            <select id="ligne" class="form-control" disabled></select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Arrêt</label>
                            <select id="arret" class="form-control" disabled></select>
                        </div>
                    </div>

                    <div id="infosTrajet"></div>
                </div>
            </div>
        </div>

        <!-- MAP -->
        <div class="container mt-3">
            <div id="map"></div>
        </div>

        <!-- LEAFLET -->
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

        <script>
            const baseUrl = window.location.origin;

            const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
            const esri = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}');

            const map = L.map('map', { layers: [osm] })
                .setView([12.238, -1.561], 12);

            L.control.layers({
                "Plan": osm,
                "Satellite": esri
            }).addTo(map);

            const busIcon = L.icon({
                iconUrl: '{{ asset("images/bus.png") }}',
                iconSize: [40, 40],
                iconAnchor: [20, 40]
            });

            let busMarker = null;
            let routeBleue = null;
            let routeRouge = null;
            let arrets = [];
            let busOrdre = null;
            let sensBus = 'aller';
            let lastDistance = null;

            const villeSelect = document.getElementById('ville');
            const ligneSelect = document.getElementById('ligne');
            const arretSelect = document.getElementById('arret');
            const infosTrajet = document.getElementById('infosTrajet');

            villeSelect.addEventListener('change', () => {
                ligneSelect.disabled = !villeSelect.value;
                ligneSelect.innerHTML = '<option>-- Ligne --</option>';
                arretSelect.disabled = true;

                fetch(`${baseUrl}/api/lignes?ville_id=${villeSelect.value}`)
                    .then(r => r.json())
                    .then(data => {
                        data.forEach(l =>
                            ligneSelect.innerHTML += `<option value="${l.id}">${l.nom}</option>`
                        );
                    });
            });
        </script>

    </div>
</div>
@endsection

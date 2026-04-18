<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Suivi des bus</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css">

    <style>
        html, body {
            width: 100%;
            overflow-x: hidden;
            background: #f6faf7;
            font-family: 'Poppins', sans-serif;
        }

        .hero {
            background: linear-gradient(135deg, #0b8f3f, #066b2e);
            color: #fff;
            text-align: center;
            padding: 40px 15px;
            border-radius: 0 0 28px 28px;
        }

        .hero h1 {
            color: #f4e000;
            font-weight: 700;
        }

        .hero-logo {
            width: 110px;
            margin-bottom: 10px;
        }

        .info-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 20px;
            margin-top: -30px;
            margin-bottom: 30px;
        }

        .info-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px 15px;
            text-align: center;
            box-shadow: 0 8px 18px rgba(0,0,0,.08);
            border-top: 4px solid #0b8f3f;
        }

        #map {
            width: 100%;
            height: 65vh;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,.12);
        }
    </style>
</head>

<body>

<div class="hero">
    <img src="/images/logo_sotraco.jpeg" class="hero-logo">
    <h1>Position du bus en temps réel</h1>
    <p>Distance et temps estimés mis à jour automatiquement</p>
</div>

<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <div class="mb-3">
                <label>Ville</label>
                <select id="ville" class="form-control">
                    <option value="">-- Sélectionner --</option>
                    @foreach($villes as $ville)
                        <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label>Ligne</label>
                    <select id="ligne" class="form-control" disabled></select>
                </div>
                <div class="col-md-6">
                    <label>Arrêt</label>
                    <select id="arret" class="form-control" disabled></select>
                </div>
            </div>

            <div id="infosTrajet" class="mt-3 fw-bold text-primary text-center"></div>
        </div>
    </div>
</div>

<div class="container mt-3 mb-4">
    <div id="map"></div>
</div>

<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

<script>
/* ================= CONFIG ================= */

const baseUrl = window.location.origin;

const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
const esri = L.tileLayer(
    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'
);

const map = L.map('map', {
    layers: [osm]
}).setView([12.238, -1.561], 12);

L.control.layers({
    "Plan": osm,
    "Satellite": esri
}).addTo(map);

const busIcon = L.icon({
    iconUrl: '/images/buss.png',
    iconSize: [40, 40],
    iconAnchor: [20, 40]
});

/* ================= VARIABLES ================= */

let busMarkers = {}; // {id: {marker, halo}}
let routeBleue = null;
let routeRouge = null;
let labelArret = null;

let arrets = [];
let arretSelectionne = null;
let busSuivi = null;

/* ================= SELECTEURS ================= */

const villeSelect = document.getElementById('ville');
const ligneSelect = document.getElementById('ligne');
const arretSelect = document.getElementById('arret');
const infosTrajet = document.getElementById('infosTrajet');

/* ================= VILLE → LIGNES ================= */

villeSelect.addEventListener('change', () => {
    ligneSelect.disabled = !villeSelect.value;
    ligneSelect.innerHTML = '<option value="">-- Ligne --</option>';
    arretSelect.disabled = true;
    arretSelect.innerHTML = '<option value="">-- Arrêt --</option>';

    fetch(`${baseUrl}/api/lignes?ville_id=${villeSelect.value}`)
        .then(r => r.json())
        .then(data => {
            data.forEach(l => {
                ligneSelect.innerHTML += `<option value="${l.id}">${l.nom}</option>`;
            });
        });
});

/* ================= LIGNE → ARRETS ================= */

ligneSelect.addEventListener('change', () => {
    arretSelect.disabled = false;
    arretSelect.innerHTML = '<option value="">-- Arrêt --</option>';

    if (routeBleue) map.removeControl(routeBleue);

    fetch(`${baseUrl}/api/arrets?ligne_id=${ligneSelect.value}`)
        .then(r => r.json())
        .then(data => {
            arrets = data.sort((a,b) => a.ordre - b.ordre);

            arrets.forEach(a => {
                arretSelect.innerHTML += `
                    <option value="${a.id}"
                        data-ordre="${a.ordre}"
                        data-lat="${a.latitude}"
                        data-lng="${a.longitude}">
                        ${a.ordre} - ${a.nom}
                    </option>`;
            });

            routeBleue = L.Routing.control({
                waypoints: arrets.map(a => L.latLng(a.latitude, a.longitude)),
                createMarker: () => null,
                addWaypoints: false,
                show: false,
                lineOptions: { styles: [{ color: 'blue', weight: 6 }] }
            }).addTo(map);
        });
});

/* ================= BUS (0,5 s) ================= */

function updateBusPosition() {
    if (!ligneSelect.value) return;

    fetch(`${baseUrl}/api/positions?ligne_id=${ligneSelect.value}`)
        .then(r => r.json())
        .then(data => {
            data.forEach(bus => {
                const pos = [bus.latitude, bus.longitude];

                if (!busMarkers[bus.id]) {
                    const marker = L.marker(pos, { icon: busIcon }).addTo(map);
                    const halo = L.circleMarker(pos, {
                        radius: 14,
                        color: '#0b8f3f',
                        fillColor: '#0b8f3f',
                        fillOpacity: 0.25
                    }).addTo(map);

                    busMarkers[bus.id] = { marker, halo };
                } else {
                    busMarkers[bus.id].marker.setLatLng(pos);
                    busMarkers[bus.id].halo.setLatLng(pos);
                }
            });
        });
}

setInterval(updateBusPosition, 500);

/* ================= ARRÊT ================= */

arretSelect.addEventListener('change', () => {
    arretSelectionne = arretSelect.value;
});

/* ================= RECALCUL (1 s) ================= */

setInterval(() => {
    if (!arretSelectionne || !arrets.length) return;

    const opt = arretSelect.options[arretSelect.selectedIndex];
    if (!opt) return;

    const arretLat = parseFloat(opt.dataset.lat);
    const arretLng = parseFloat(opt.dataset.lng);

    let min = Infinity;
    busSuivi = null;

    Object.values(busMarkers).forEach(b => {
        const d = map.distance(b.marker.getLatLng(), [arretLat, arretLng]);
        if (d < min) {
            min = d;
            busSuivi = b.marker;
        }
    });

    if (!busSuivi) return;

    if (routeRouge) map.removeControl(routeRouge);
    if (labelArret) map.removeLayer(labelArret);

    labelArret = L.tooltip({ permanent: true })
        .setLatLng([arretLat, arretLng])
        .setContent(opt.text)
        .addTo(map);

    routeRouge = L.Routing.control({
        waypoints: [
            busSuivi.getLatLng(),
            ...arrets
                .filter(a => a.ordre >= opt.dataset.ordre)
                .map(a => L.latLng(a.latitude, a.longitude))
        ],
        createMarker: () => null,
        addWaypoints: false,
        show: false,
        lineOptions: { styles: [{ color: 'red', weight: 7 }] }
    }).on('routesfound', e => {
        const r = e.routes[0];
        infosTrajet.innerHTML = `
            Distance : ${(r.summary.totalDistance/1000).toFixed(2)} km<br>
            Temps : ${Math.round(r.summary.totalTime/60)} min
        `;
    }).addTo(map);

}, 1000);
</script>


</body>
</html>
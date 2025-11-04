<?php
require 'functions.php';

// Ambil data universitas dari database
$universities = send_query("SELECT id, name, address, ST_X(coordinate) AS lat, ST_Y(coordinate) AS lng FROM Universities");
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Universitas</title>

    <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">


    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        #map { height: 600px; }
    </style>
</head>
<body>
<main class="container-fluid p-3">
    <h1 class="mb-3 text-center">Daftar Universitas</h1>
    <div class="row">
        <!-- Bagian kiri: tabel data -->
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($universities as $row): ?>
                                <tr>
                                    <td><?= $row['name']; ?></td>
                                    <td><?= $row['address']; ?></td>
                                    <td>
                                        <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                                        <a href="update.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Update</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bagian kanan: peta -->
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Script Leaflet -->
<script>
    // Inisialisasi peta
    var map = L.map('map').setView([-0.06043501742395956, 109.349325562800941], 13);

    // Tambahkan tile layer
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Ambil data universitas dari PHP
    var universities = <?php echo json_encode($universities); ?>;

    // Tambahkan marker ke peta
    universities.forEach(function(row) {
        L.marker([row.lat, row.lng])
            .addTo(map)
            .bindPopup("<b>" + row.name + "</b><br>" + row.address);
    });
</script>
</body>
</html>

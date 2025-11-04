<?php
// Mengammbil data spasial dari mysql

// Buka Koneksi Ke Database
$connection = mysqli_connect('localhost','root','','gis_29');

// Membuat function mengabil data berdasarkan query
function send_query($query) {
    global $connection;
    $result = mysqli_query($connection, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Siapkan query ambil data
$query = "SELECT id, name, address, ST_X(coordinate) AS lat, ST_Y(coordinate) AS lng FROM universities";

// Mengambil data spasial dari mysql melalui query
$universities = send_query($query);
var_dump($universities)
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Read</title>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        #map { height: 720px; }
    </style>
</head>
<body>
    <div id="map"></div>
<!-- Script Leaflet -->
<script>
       var map = L.map('map').setView([-0.06043501742395956, 109.349325562800941], 13);
       // Tambahkan tile layer
       L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
           maxZoom: 19,
           attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
       }).addTo(map);

       var universities = <?php echo json_encode($universities); ?>;
       universities.forEach(function(row) {
           L.marker([row.lat, row.lng])
               .addTo(map)
               .bindPopup("<b>" + row.name + "</b><br>" + row.address);
       });
   </script>
</body>
</html>

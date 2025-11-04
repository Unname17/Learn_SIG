<?php
// Buka Koneksi Ke Database
$connection = mysqli_connect('localhost','root','','gis_29');

// Menggambil data dari form create.html
$name = $_POST['name'];
$address = $_POST['address'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];

// Siapkan query untuk tambah baris di table universities
$query = "INSERT INTO universities (name, address, coordinate) VALUES ('$name','$address',ST_GeomFromText('POINT($lat $lng)',4326))";

// Kirim query ke MYSQL
mysqli_query($connection, $query)
?>
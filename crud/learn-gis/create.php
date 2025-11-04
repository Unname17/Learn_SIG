<?php

$connection = mysqli_connect('localhost','root','','learn_gis');

function send_query($query) {
    global $connection;
    $result = mysqli_query($connection, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows [] = $row;
    }
    return $rows;
}

$name = $_POST['name'];
$address = $_POST['address'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];

$query = "INSERT INTO Universities(name, address, coordinate) VALUES ('$name', '$address', ST_GeomFromText('POINT($lat $lng)',4326))";
mysqli_query($connection, $query);

?>
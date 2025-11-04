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
?>

<?php
$server = "localhost";
$username = "root";
$password = "28052018";
$database = "sistemaDeUsuario";

$conn = mysqli_connect($server, $username, $password, $database);

if(mysqli_connect_error()){
    echo "Falha ao se conectar ao banco: " . mysqli_connect_error();
}
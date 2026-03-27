<?php
include 'configdb.php';
echo "test";

$conn = mysqli_connect($host, $user, $password, $database);
echo mysqli_get_client_info();
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connexion réussie";

?>
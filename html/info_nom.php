<!-- Init de la connexion à la BDD -->
<?php
include 'configdb.php';
$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Erreur : " . mysqli_connect_error());
}
    echo "Connexion réussie";
?>

<!-- Partie HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Neticar – Rechercher</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style2.css">
</head>
<body>

<!-- Barre de recherche -->
<form method="GET" action="">
    <input type="text" name="nom" placeholder="Ex : Dupont">
    <button type="submit">Rechercher</button>
</form>

<!-- Partie résultats -->
<div id="resultats">
    <?php
    $nom = trim($_GET['nom'] ?? '');

    $stmt = $conn->prepare("SELECT nom");
    while ($row = mysqli_fetch_assoc($query_uni)) {
        echo "<pre>";
        print_r($row);
        echo "</pre>";
    }

    ?>
</div>

</body>
</html>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include __DIR__ . '/configdb.php';
$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
  die("Erreur : " . mysqli_connect_error());
}

$recherche = trim($_GET['recherche'] ?? '');
$param = '%' . $recherche . '%';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Neticar – Rechercher</title>
  <link rel="stylesheet" href="css/style2.css">
</head>
<body>

<form method="GET">
  <input type="text" name="recherche" placeholder="Ville, nom..." value="<?= htmlspecialchars($recherche) ?>">
  <button type="submit">Rechercher</button>
</form>

<?php if ($recherche !== ''): ?>

  <?php
  $stmt = $conn->prepare("
        SELECT e.nom, e.prenom, t.adresse_dep, t.adresse_arr, t.date, t.heure_deb, t.cout_indiv
        FROM info_traj t
        JOIN equipage eq ON eq.IDTrajet  = t.IDTrajet
        JOIN etudiant e  ON e.IDEtudiant = eq.IDEtudiant
        WHERE t.adresse_dep LIKE ?
           OR t.adresse_arr LIKE ?
           OR e.nom         LIKE ?
           OR e.prenom      LIKE ?
    ");
  $stmt->bind_param("ssss", $param, $param, $param, $param);
  $stmt->execute();
  $result = $stmt->get_result();
  ?>

  <?php if ($result->num_rows === 0): ?>
    <p>Aucun résultat pour "<?= htmlspecialchars($recherche) ?>"</p>
  <?php endif; ?>

  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="card">
      <h3><?= htmlspecialchars($row['prenom']) ?> <?= htmlspecialchars($row['nom']) ?></h3>
      <p><?= htmlspecialchars($row['adresse_dep']) ?> → <?= htmlspecialchars($row['adresse_arr']) ?></p>
      <p><?= htmlspecialchars($row['date']) ?> à <?= htmlspecialchars($row['heure_deb']) ?></p>
      <p><?= htmlspecialchars($row['cout_indiv']) ?> €</p>
    </div>
  <?php endwhile; ?>

<?php endif; ?>

</body>
</html>

<?php
header('Content-Type: application/json');
// Fichier contenant les definitions de constantes
// pour la connexion à MySQL
require "connect.php";
$conn = new mysqli(SERVEUR, NOM, PASSE, BASE);
if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}
$conn->set_charset("utf8mb4");

$query = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';
$suggestions = [];

if (strlen($query) >= 1) {
    $sql = "
        SELECT nom FROM villes WHERE nom LIKE '%$query%'
        UNION
        SELECT nom FROM departements WHERE nom LIKE '%$query%'
        UNION
        SELECT nom FROM provinces WHERE nom LIKE '%$query%'
        UNION
        SELECT nom FROM ethnies WHERE nom LIKE '%$query%'
        UNION
        SELECT nom FROM personnages WHERE nom LIKE '%$query%'
        LIMIT 8
    ";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row['nom'];
    }
}
echo json_encode($suggestions);
?>

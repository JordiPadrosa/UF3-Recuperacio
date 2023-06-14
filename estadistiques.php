<?php
session_start();

function llegirParticipants() : array | null {
    try {
        $hostname = "localhost";
        $dbname = "uf3";
        $username = "uf3";
        $pw = "uf3";
        $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    $query = $pdo->prepare("SELECT p.nom, COUNT(a.via) AS vies
    FROM participants p
    INNER JOIN assoliments a ON p.email = a.participant
    GROUP BY p.nom
    ORDER BY vies DESC
    LIMIT 10");
    $query->execute();
    $participants = [];
    foreach ($query as $row ) {
    $participants[] = $row;
    }
    return $participants;
}

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN - Concurs Internacional de Gossos d'Atura</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper medium">
    <header>LLISTAT PARTICIPANTS:</header>
    <div class="admin">
        <div class="admin-row">
            <table>
                <tr>
                    <th>NOM</th>
                </tr>
                <?php
                $participants = llegirParticipants();
                foreach ($participants as $participant) {
                    echo "<tr>";
                    echo "<td>" . $participant["nom"] . "</td>";
                    echo "<td>" . $participant["vies"] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>            
        </div>
    </div>
</div>

</body>
</html>
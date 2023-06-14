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

    $query = $pdo->prepare("SELECT p.nom, a.via, a.encadenat, a.primer, COUNT(a.intent) AS intents FROM participants p
    INNER JOIN assoliments a ON p.email = a.participant GROUP BY p.nom, a.via ORDER BY p.nom ASC");
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
                    if($participant["intents"]){
                        if ($participant["intents"] == 1) {
                            echo "<td><b>" . $participant["via"] . "</b></td>";
                        }elseif($participant["encadenat"] == 1 && $participant["primer"] == 1){
                            echo "<td style='color: blue;'>" . $participant["via"] . "</td>";
                        }else {
                            echo "<td>" . $participant["via"] . "</td>";
                        }
                    }  
                    echo "</tr>";
                }
                ?>
            </table>            
        </div>
    </div>
</div>

</body>
</html>
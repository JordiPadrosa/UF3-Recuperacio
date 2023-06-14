<?php
session_start();

if(!isset($_SESSION["errorUsuari"])){
    $_SESSION["errorUsuari"]= 0;
}
if(!isset($_SESSION["errorConcursant"])){
    $_SESSION["errorConcursant"]= 0;
}
if(!isset($_SESSION["errorData"])){
    $_SESSION["errorData"]= 0;
}
if(!isset($_SESSION["errorFase"])){
    $_SESSION["errorFase"]= 0;
}

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

    $query = $pdo->prepare("select email FROM participants");
    $query->execute();
    $participants = [];
    foreach ($query as $row ) {
    $participants[] = $row;
    }
    return $participants;
}

function llegirVies() : array | null {
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

    $query = $pdo->prepare("select nom FROM vies");
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
    <header>ASSOLIMENTS</header>
    <div class="admin">
        <div class="admin-row">
            <h1> Nou Assoliment: </h1>
            <form action="process.php" method="post">
                <input type="hidden" name="method" value="crearAssoliment"/>
                <select name="participant">
                    <?php foreach (llegirParticipants() as $participant){  ?>
                    <option value="<?php echo $participant[0];?>"><?php echo $participant[0] ?></option>
                    <?php } ?>
                </select> 
                <select name="via">
                    <?php foreach (llegirVies() as $via){  ?>
                    <option value="<?php echo $via[0];?>"><?php echo $via[0] ?></option>
                    <?php } ?>
                </select> 
                <input type="date" name="data" placeholder="Data">
                <input type="checkbox" name="encadenat">Encadenat</input>
                <input type="checkbox" name="primer">Primer</input>
                <select name="assegurador">
                    <?php foreach (llegirParticipants() as $participant){  ?>
                    <option value="<?php echo $participant[0];?>"><?php echo $participant[0] ?></option>
                    <?php } ?>
                </select> 
                <input type="submit">
            </form>
        </div>
    </div>
</div>

</body>
</html>
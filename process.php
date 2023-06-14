<?php
session_start();
if($_POST["method"] == "crearUsuari") {
    if($_POST["nom"] != "" && $_POST["cognom"] != "" && $_POST["email"] != ""){
        if(strlen($_POST["nom"]) < 100 || strlen($_POST["cognom"]) < 100 || strlen($_POST["email"]) < 100){
            $dades = array($_POST["nom"], $_POST["cognom"], $_POST["email"]);
            $buscarCorreu = llegeixUsuari();
            if(!in_array($dades[2], $buscarCorreu)){
                crearUsuari($dades);
                header("Location: assoliments.php");
            }
        }
    }
    header("Location: registre.php");
}elseif($_POST["method"] == "crearAssoliment"){
    // if($_POST["data"] != "" && ($_POST["encadenat"] == "true" || $_POST["encadenat"] == "false")
    // && ($_POST["primer"] != "" || $_POST["primer"] == "false")){
        $encadenat = false;
        $primer = false;
        if(isset($_POST["encadenat"])){
            $encadenat = true;
        }
        if(isset($_POST["primer"])){
            $primer = true;
        }
        if($_POST["participant"] != $_POST["assegurador"]){
            $llegirAssoliment = llegirAssoliments($_POST["participant"], $_POST["via"]);
            $intent = 1;
            if($llegirAssoliment){
                $intent = $llegirAssoliment[0]+1;
            }
            $dades = array($_POST['participant'], $_POST["via"], $intent, $_POST["data"], $encadenat, $primer, $_POST["assegurador"]);
            crearAssoliment($dades);
        }
    // }
    header("Location: assoliments.php");
}elseif($_POST["method"] == "borrarAssoliments"){
    borrarAssoliments();
    header("Location: debug.php");
}elseif($_POST["method"] == "borrarParticipants"){
    borrarParticipants();
    header("Location: debug.php");
}elseif($_POST["method"] == "borrarViesSectors"){
    borrarViesSectors();
    header("Location: debug.php");
}elseif($_POST["method"] == "insertViesSectors"){
    insertViesSectors();
    header("Location: debug.php");
}

/**
 * Accedeix a la base de dades i retorna els usuaris
 *
 * @return array | null
 */
function llegeixUsuari() : array | null
{
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
    $users = [];
    foreach ($query as $row ) {
    $users[] = $row['email'];
    }
    return $users;
}

/**
 * Guarda les dades de registre a la base de dades
 *
 * @param array $dades que conte l'usuari i contrasenya
 */
function crearUsuari(array $dades): void {
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

    $sql = "INSERT INTO participants VALUES(?, ?, ?)";
    $query = $pdo->prepare($sql);
    $query->execute(array($dades[0], $dades[1], $dades[2]));
}

/**
 * Guarda les dades del formulari a la base de dades
 *
 * @param array $dades assoliment
 */
function crearAssoliment(array $dades): void {
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

    $sql = "INSERT INTO assoliments VALUES(?, ?, ?, ?, ?, ?, ?)";
    $query = $pdo->prepare($sql);
    $query->execute(array($dades[0], $dades[1], $dades[2], $dades[3], $dades[4], $dades[5], $dades[6]));
}

/**
 * Accedeix a la base de dades i retorna els assoliments
 *
 * @param string $participant
 * @param string $via
 * @return array | null
 */
function llegirAssoliments(string $participant, string $via): array | null
{
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

    $query = $pdo->prepare("select MAX(intent) FROM assoliments WHERE participant = ? AND via = ?");
    $query->execute(array($participant, $via));
    $assoliments = [];
    foreach ($query as $row ) {
        $assoliments[] = $row['MAX(intent)'];
    }
    return $assoliments;
}

function borrarAssoliments() {
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

    $query = $pdo->prepare("DELETE FROM assoliments");
    $query->execute();
}

function borrarParticipants() {
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

    $query = $pdo->prepare("DELETE FROM participants");
    $query->execute();
}

function borrarViesSectors() {
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

    $query = $pdo->prepare("DELETE FROM vies");
    $query->execute();
    $query = $pdo->prepare("DELETE FROM sectors");
    $query->execute();
}

function insertViesSectors() {
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

    $query = $pdo->prepare("INSERT INTO vies (Nom, Sector, Grau)
    VALUES ('Rollo Love', 'Collegats - La pedrera', '8a'),
           ('Rollo Javalí', 'Collegats - La pedrera', '8a+'),
           ('Bioactiva', 'Collegats - La pedrera', '7c+'),
           ('L’arcada del dimoni', 'Sadernes - El diable', '7b'),
           ('Bruixots', 'Sadernes - El diable', '6c+')");
    $query->execute();
    
}

?>
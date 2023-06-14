<?php
session_start();

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
            <form action="process.php" method="post">
                Esborra tots els assoliments
                <input type="hidden" name="method" value="borrarAssoliments"/>
                <input type="submit">
            </form>
            <form action="process.php" method="post">
                Esborra tots els participants
                <input type="hidden" name="method" value="borrarParticipants"/>
                <input type="submit">
            </form>
            <form action="process.php" method="post">
                Esborra totes les vies i sectors
                <input type="hidden" name="method" value="borrarViesSectors"/>
                <input type="submit">
            </form>
            <form action="process.php" method="post">
                Introduir automàticament sectors i vies
                <input type="hidden" name="method" value="insertViesSectors"/>
                <input type="submit">
            </form>    
        </div>
    </div>
</div>

</body>
</html>
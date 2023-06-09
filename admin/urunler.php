<?php

// session başlatarak tarayıcı belleğindeki admin_id değerini alıp admin kontrolü yapıyoruz.
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin-giris.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Getirme | Anasayfa </title>
    <link rel="stylesheet" href="../reset.css">
    <link rel="stylesheet" href="../index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a20f77a62b.js" crossorigin="anonymous"></script>
</head>

<body>

    <header>
       
    <a href="../admin/">
            <div class="site-logo"></div>
        </a>


        <div style="display: flex;flex-direction: row;justify-content: center;align-items: center;">
            <?php require("../asd/admin_name.php") ?>

            <?php require_once("cikis-yap.php"); ?>
        </div>

    </header>

    <main>
        <h1>Urunlerim</h1>
        <main>
            <p class="restaurant-title">
                Restaurant 1
            </p>
            <div class="restaurant">
                <?php
                require_once("../asd/urunlerim-card.php");
                ?>
            </div>
        </main>
    </main>

    <footer></footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>
<?php
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
</head>

<body>


    <header>
        <!--  <a href="../restaurant-proje/">
            <h1> Getirme </h1>
        </a> -->

        <a href="../">
            <div class="site-logo"></div>
        </a>


        <p>Restaurant1 - admin</p>

    </header>


    <main>
        <h1>Admin Paneli</h1>
        <div class="admin-grid">
            <div>
                <a href="siparisler.php">
                    Siparisler
                </a>
            </div>
            <div>
                <a href="urunler.php">
                    Urunler
                </a>
            </div>

            <div>
                <a href="urun_ekle.php">
                    Yeni Urun Ekle
                </a>
            </div>

        </div>
    </main>

    <footer style="position: absolute;bottom: 0;"></footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>
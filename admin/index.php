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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../reset.css">
    <link rel="stylesheet" href="../index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a20f77a62b.js" crossorigin="anonymous"></script>
    <style>
        .admin-grid div {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .admin-grid i {
            font-size: 30px;
        }
    </style>
</head>

<body>


    <header>
        <!--  <a href="../restaurant-proje/">
            <h1> Getirme </h1>
        </a> -->

        <a href="../">
            <div class="site-logo"></div>
        </a>


        <div style="display: flex;flex-direction: row;justify-content: center;align-items: center;">
            <?php
            /* print($_SESSION["admin_id"]); */
            require_once("../conn.php");
            session_start();
            $admin_id = $_SESSION["admin_id"];
            $sql = "select admin_name from admins where restaurant_id = $admin_id";
            $sth = $dbconn->prepare($sql);
            $sth->execute();
            $adminnnn = $sth->fetch(PDO::FETCH_ASSOC)["admin_name"];
            ?>
            <p>
                <?php echo $adminnnn; ?>
            </p>
            <?php require_once("cikis-yap.php"); ?>
        </div>
    </header>


    <main>
        <h1>Admin Paneli</h1>
        <div class="admin-grid" style="    grid-template-columns: 1fr 1fr 1fr 1fr;">
            <div>
                <div> <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i></div>
                <a href="siparisler.php">

                    Siparisler
                </a>
            </div>
            <div>
                <div>
                    <i class="fa-solid fa-burger" style="color: #ffffff;"></i>
                </div>
                <a href="urunler.php">
                    Urunler
                </a>
            </div>

            <div>
                <div><i class="fa-solid fa-plus" style="color: #ffffff;"></i></div>
                <a href="urun_ekle.php">
                    Yeni Urun Ekle
                </a>
            </div>
            <div>
                <div><i class="fa-solid fa-arrow-down-wide-short" style="color: #ffffff;"></i></div>
                <a href="istatistikler.php">
                    Istatistikler
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
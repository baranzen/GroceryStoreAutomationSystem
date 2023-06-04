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
        <a href="../">
            <div class="site-logo"></div>
        </a>


        <div style="display: flex;flex-direction: row;justify-content: center;align-items: center;">
            <p>Restaurant1 - admin</p>
            <?php require_once("cikis-yap.php"); ?>
        </div>

    </header>


    <main>
        <h1>Istatistikler</h1>
        <div>
            <?php


            $host = "localhost";
            $dbName = "getirme";
            $root = "root";
            $psw = "";

            try {
                $dbconn = new PDO("mysql:host=$host;dbname=$dbName", $root, $psw) or
                    die("baglanti olmadi.");
            } catch (PDOException $e) {
                echo "hata: " . $e;
            }
            function totalOrder($dbconn)
            {
                $sql = "select * from orders where restaurant_id = 1";
                $sth = $dbconn->prepare($sql);
                $sth->execute();
                $orders = $sth->fetchAll(PDO::FETCH_ASSOC);

                $groupedOrders = array();
                foreach ($orders as $order) {
                    $combineId = $order["combine_id"];
                    if (isset($groupedOrders[$combineId])) {
                        $groupedOrders[$combineId][] = $order;
                    } else {
                        $groupedOrders[$combineId] = array($order);
                    }
                }
                $groupedOrders = array_reverse($groupedOrders, false);
                return count($groupedOrders);
            }

            function totalGiro($dbconn)
            {
                $sql = "SELECT SUM(product_price) from orders where restaurant_id = 1";
                $result = $dbconn->query($sql);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                return $row["SUM(product_price)"];
            }

            function totalProducts($dbconn)
            {
                $sql = "SELECT COUNT(*)from orders where restaurant_id = 1";
                $result = $dbconn->query($sql);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                return $row["COUNT(*)"];
            }
            require_once("../conn.php");
            ?>
            <div class="admin-grid">
                <div>
                    <div> <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i></div>
                    <a href="siparisler.php">

                        Siparis Sayisi:
                        <?php echo totalOrder($dbconn); ?>
                    </a>
                </div>
                <div>
                    <div>
                        <i class="fa-solid fa-burger" style="color: #ffffff;"></i>
                    </div>
                    <a href="urunler.php">
                        Urun Sayisi:
                        <?php echo totalProducts($dbconn); ?>
                    </a>
                </div>

                <div>
                    <div><i class="fa-solid fa-dollar-sign" style="color: #ffffff;"></i></div>
                    <a href="urun_ekle.php">
                        Toplam Ciro:
                        <?php echo totalGiro($dbconn); ?>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <footer style="position: absolute;bottom: 0;"></footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>
<?php
// bu sayfada admine restaurant istatistiklerini gösteriyoruz.


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

        <a href="../admin/">
            <div class="site-logo"></div>
        </a>


        <div style="display: flex;flex-direction: row;justify-content: center;align-items: center;">
            <?php require("../asd/admin_name.php") ?>

            <?php require_once("cikis-yap.php"); ?>
        </div>

    </header>


    <main>
        <h1>Istatistikler</h1>
        <div>
            <?php

            // veritabanı bağlantısı
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

            // sipariş sayısını hesaplayan fonksiyon dbconn veritabanı bağlantısını parametre olarak alıyor.
            function totalOrder($dbconn)
            {
                // session başlatma
                session_start();
                // admin id değerini alıyoruz.
                $admin_id = $_SESSION["admin_id"];
                // admin id değerine göre siparişleri çekiyoruz.
                $sql = "select * from orders where restaurant_id = $admin_id";
                $sth = $dbconn->prepare($sql);
                $sth->execute();
                // siparişleri $orders değişkenine atıyoruz.
                $orders = $sth->fetchAll(PDO::FETCH_ASSOC);

                /*
    orders tablosundan gelen verileri combine_id değerine göre grupluyoruz.combine_id 
 değeri aynı anda sipariş verilmiş ürünler  bir array içerisine alıyoruz. 
 */
                $groupedOrders = array();
                foreach ($orders as $order) {
                    // combine_id değerini alıyoruz.
                    $combineId = $order["combine_id"];
                    if (isset($groupedOrders[$combineId])) {
                        // combine_id değeri aynı olanları bir array içerisine alıyoruz.
                        $groupedOrders[$combineId][] = $order;
                    } else {
                        // combine_id değeri aynı olmayanları bir array içerisine alıyoruz.
                        $groupedOrders[$combineId] = array($order);
                    }
                }
                // burada arrayi ters çeviriyoruz ki en son eklenen en üstte gözüksün.
                $groupedOrders = array_reverse($groupedOrders, false);
                // arrayin uzunluğunu döndürüyoruz bu da sipariş sayısını veriyor.
                return count($groupedOrders);
            }
            // toplam giro hesaplayan fonksiyon dbconn veritabanı bağlantısını parametre olarak alıyor.
            function totalGiro($dbconn)
            {
                // session başlatma
                session_start();
                // admin id değerini alıyoruz.
                $admin_id = $_SESSION["admin_id"];
                // admin id değerine göre product_price değerlerini topluyoruz.
                $sql = "SELECT SUM(product_price) from orders where restaurant_id =  $admin_id";
                $result = $dbconn->query($sql);
                // row değişkenine topalanan değeri atıyoruz.
                $row = $result->fetch(PDO::FETCH_ASSOC);
                // toplam giro değerini döndürüyoruz.
                return $row["SUM(product_price)"];
            }

            // toplam ürün sayısını hesaplayan fonksiyon dbconn veritabanı bağlantısını parametre olarak alıyor.
            function totalProducts($dbconn)
            {
                // session başlatma
                session_start();
                // admin id değerini alıyoruz.
                $admin_id = $_SESSION["admin_id"];
                // admin id değerine göre tüm stünların sayısını çekiyoruz.
                $sql = "SELECT COUNT(*)from orders where restaurant_id = $admin_id";
                $result = $dbconn->query($sql);
                // row değişkenine topalanan değeri atıyoruz.
                $row = $result->fetch(PDO::FETCH_ASSOC);
                // toplam ürün sayısını döndürüyoruz.
                return $row["COUNT(*)"];
            }

            // en çok sipariş verilen ürünü hesaplayan fonksiyon. dbconn veritabanı bağlantısını parametre olarak alıyor.
            function mostOrderedProduct($dbconn)
            {
                // session başlatma
                session_start();
                // admin id değerini alıyoruz.
                $admin_id = $_SESSION["admin_id"];
                // admin id değerine göre tüm stünların sayısını çekiyoruz.
                $sql = "select * from orders where restaurant_id = $admin_id";
                $sth = $dbconn->prepare($sql);
                $sth->execute();
                // siparişleri $orders değişkenine atıyoruz.
                $orders = $sth->fetchAll(PDO::FETCH_ASSOC);

                /*
orders tablosundan gelen verileri combine_id değerine göre grupluyoruz.combine_id 
değeri aynı anda sipariş verilmiş ürünler  bir array içerisine alıyoruz. 
*/
                $groupedOrders = array();
                foreach ($orders as $order) {
                    // combine_id değerini alıyoruz.
                    $combineId = $order["combine_id"];
                    if (isset($groupedOrders[$combineId])) {
                        // combine_id değeri aynı olanları bir array içerisine alıyoruz.
                        $groupedOrders[$combineId][] = $order;
                    } else {
                        // combine_id değeri aynı olmayanları bir array içerisine alıyoruz.
                        $groupedOrders[$combineId] = array($order);
                    }
                }

                // burada arrayi ters çeviriyoruz ki en son eklenen en üstte gözüksün.
                $groupedOrders = array_reverse($groupedOrders, false);
                //return product_name
            
                // burada en çok sipariş verilen ürünü hesaplıyoruz. 
                // $productCount değişkenine ürün adını ve kaç adet sipariş verildiğini atıyoruz.
            
                $productCount = array();
                foreach ($groupedOrders as $order) {
                    foreach ($order as $product) {
                        // product_name değerini alıyoruz.
                        $product_name = $product["product_name"];
                        // eğer product_name değeri varsa bir arttırıyoruz.
                        if (isset($productCount[$product_name])) {
                            $productCount[$product_name]++;
                        } else {
                            // eğer product_name değeri yoksa 1 atıyoruz.
                            $productCount[$product_name] = 1;
                        }
                    }
                }

                // array_keys fonksiyonu ile en çok sipariş verilen ürünün adını buluyoruz. bu şu yüzden kullandık çünkü arrayin içindeki değerleri bulmak için arrayin key değerlerine ihtiyacımız var.
                $mostOrderedProduct = array_keys($productCount, max($productCount));
                // en çok sipariş verilen ürünü döndürüyoruz.
                return $mostOrderedProduct[0];
            }
            /* ve html ile listeliyoruz */
            ?>
            <div class="admin-grid" style="    grid-template-columns: 1fr 1fr 1fr 1fr;">
                <div>
                    <div>
                        <i class="fa-solid fa-burger" style="color: #ffffff;"></i>
                    </div>
                    <a href="urunler.php">
                        Trend urun:
                        <?php echo mostOrderedProduct($dbconn); ?>
                    </a>
                </div>
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
<?php
// bu dosyada restaurantların listelenmesi ve ürünlerin listelenmesi işlemi yapılıyor.

//veritabanı bağlantısı
require_once("conn.php");

// tüm restoranları restaurants tablosundan çekiyoruz.
$sql = "select * from restaurants";
$sth = $dbconn->prepare($sql);
$sth->execute();
// restoranları $restaurants değişkenine atıyoruz.
$restaurants = $sth->fetchAll(PDO::FETCH_ASSOC);
// restaurants değişkenini elemanlarını geziyoruz.
foreach ($restaurants as $restaurant) {
    ?>
    <p class="restaurant-title">
        <!-- restaurant ismi -->
        <?php echo $restaurant["restaurant_name"]; ?>
    </p>


    <div class="restaurant">
        <?php
        // restorant olup olmadığını kontrol ediyoruz.
        if ($restaurants != null) {
            // resotrant id sini alıyoruz.
            $restaurantID = $restaurant["restaurant_id"];
            // resotarnt id sine göre ürünleri çekiyoruz.
            $sql = "select * from products where restaurant_id = $restaurantID";
            $sth = $dbconn->prepare($sql);
            $sth->execute();
            // ürünleri $urunler değişkenine atıyoruz.
            $urunler = $sth->fetchAll(PDO::FETCH_ASSOC);

            // ürünlerin olup olmadığını kontrol ediyoruz.
            if ($urunler != null) {
                // for ile ürünleri geziyoruz.
                for ($i = 0; $i < count($urunler); $i++) {
                    // ürünleri $urun değişkenine atıyoruz.
                    $urun = $urunler[$i];
                    // ürün bilgilerini değişkenlere atıyoruz.
                    $urun_name = $urun["product_name"];
                    $urun_price = $urun["product_price"];
                    $urun_image_url = $urun["product_url"];
                    $product_id = $urun["product_id"];
                    ?>

                    <div class="card" style="width: 18rem;">
                        <!-- ürünleri html ile listeliyoruz -->
                        <img class="card-img-top" src=" <?php echo $urun_image_url; ?>" alt="Card image cap">
                        <div class="card-body">
                            <form method="POST">
                                <h5 class="card-title">
                                    <?php echo $urun_name; ?>
                                </h5>
                                <p class="card-text">
                                    <?php echo $urun_price; ?>
                                </p>
                                <button type="submit" name="btn" value="<?php echo $product_id ?>" class="btn btn-primary">Ekle</button>
                            </form>
                        </div>
                    </div>

                    <?php

                }
            } else {
                echo "Ürün bulunmamaktadır.";
            }

        } else {
            echo "Restorant bulunmamaktadır.";
        }
        ?>
    </div>

    <?php
}

//  sepete ürün ekleme işlemi
if (isset($_POST["btn"])) {
    // session başlatma
    session_start();
    /* burada ekle butonuna basıldığında hangi ürünün eklenmesi gerektiğini ayırt 
edebilmemiz için butondan gelen product_id value değerini post ile çekiyoruz */
    $product_id = $_POST["btn"];
    // eğer sepet session ı ve sepetRestaurantID session ı yoksa oluşturuyoruz.
    if (!isset($_SESSION["sepet"]) && !isset($_SESSION["sepetRestaurantID"])) {
        $_SESSION["sepet"] = array();
        $_SESSION["sepetRestaurantID"] = array();
    }
    // sepet session ına product id yi push ediyoruz.
    array_push($_SESSION["sepet"], $product_id);
    // product id ye göre restaurant id yi buluyoruz.
    $sql = "select restaurant_id from products where product_id = $product_id";
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    // restaurant id yi $restaurant_id değişkenine atıyoruz.
    $restaurant_id = $sth->fetch(PDO::FETCH_ASSOC)["restaurant_id"];

    // sepetRestaurantID session ına restaurant id yi push ediyoruz.
    /* böylece aynı anda 2 restauranttan sipariş verilmesini kontrol edeceğiz */
    array_push($_SESSION["sepetRestaurantID"], $restaurant_id);

    // sepet session ında aynı ürünlerin olmaması için unique yapıyoruz.
    $_SESSION["sepet"] = array_unique($_SESSION["sepet"]);
    // sepetRestaurantID session ında aynı restaurantların olmaması için unique yapıyoruz.
    $_SESSION["sepetRestaurantID"] = array_unique($_SESSION["sepetRestaurantID"]);


    /*     print_r($_SESSION["sepetRestaurantID"]); */
}
?>
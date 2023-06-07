<?php
require_once("conn.php");

$sql = "select * from restaurants";
$sth = $dbconn->prepare($sql);
$sth->execute();
$restaurants = $sth->fetchAll(PDO::FETCH_ASSOC);
foreach ($restaurants as $restaurant) {
    ?>
    <p class="restaurant-title">
        <?php echo $restaurant["restaurant_name"]; ?>
    </p>


    <div class="restaurant">
        <?php
        if ($restaurants != null) {


            $restaurantID = $restaurant["restaurant_id"];
            $sql = "select * from products where restaurant_id = $restaurantID";
            $sth = $dbconn->prepare($sql);
            $sth->execute();
            $urunler = $sth->fetchAll(PDO::FETCH_ASSOC);

            if ($urunler != null) {

                for ($i = 0; $i < count($urunler); $i++) {
                    $urun = $urunler[$i];
                    $urun_name = $urun["product_name"];
                    $urun_price = $urun["product_price"];
                    $urun_image_url = $urun["product_url"];
                    $product_id = $urun["product_id"];
                    ?>

                    <div class="card" style="width: 18rem;">
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
}  if (isset($_POST["btn"])) {
    session_start();
    $product_id = $_POST["btn"];
    if (!isset($_SESSION["sepet"]) && !isset($_SESSION["sepetRestaurantID"])) {
        $_SESSION["sepet"] = array();
        $_SESSION["sepetRestaurantID"] = array();
    }
    array_push($_SESSION["sepet"], $product_id);
    // product id ye göre restaurant id yi bul
    $sql = "select restaurant_id from products where product_id = $product_id";
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    $restaurant_id = $sth->fetch(PDO::FETCH_ASSOC)["restaurant_id"];

    array_push($_SESSION["sepetRestaurantID"], $restaurant_id);

    $_SESSION["sepet"] = array_unique($_SESSION["sepet"]);
    $_SESSION["sepetRestaurantID"] = array_unique($_SESSION["sepetRestaurantID"]);


    print_r($_SESSION["sepetRestaurantID"]);
}
?>
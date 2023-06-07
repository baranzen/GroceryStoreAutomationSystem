<?php
require_once("conn.php");

session_start();
$restaurantID = $_SESSION["sepetRestaurantID"];

if (count($restaurantID) > 1) {
    unset($_SESSION["sepet"]);
    unset($_SESSION["sepetRestaurantID"]);
    echo "<script>alert('Sepette birden fazla restorant var. Lütfen tek restorant seçiniz.')</script>";
    header("index.php");
} 

$sepet = $_SESSION["sepet"];
print_r($_SESSION["sepetRestaurantID"]);


$urunler = array();
foreach ($sepet as $key) {
    $sql = "select * from products where product_id = $key";
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    $urun = $sth->fetch(PDO::FETCH_ASSOC);
    array_push($urunler, $urun);
}

?>
<div style="display: flex;flex-direction: column;">
    <?php
    $total_price = 0;
    for ($i = 0; $i < count($urunler); $i++) {
        $urun = $urunler[$i];
        $urun_name = $urun["product_name"];
        $urun_price = $urun["product_price"];
        $urun_image_url = $urun["product_url"];
        $productID = $urun["product_id"];
        $total_price += $urun_price;
        ?>

        <div>
            <div style="display: flex;flex-direction: row; justify-content: space-between;padding: 0;">
                <p>
                    <?php echo $urun_name ?>
                </p>
                <p style="font-style: italic;font-size: larger;">
                    <?php echo $urun_price ?>₺
                </p>
            </div>
            <hr>
        </div>

        <?php
    }
    ?>
</div>

<div class="sepet-toplam" style="margin-top: 20%;">
    <div>
        <p> Toplam </p>
        <p style="font-style: italic;font-size: x-large;">
            <?php echo $total_price ?>₺
        </p>
    </div>
    <div>
        <form action="#" method="POST">
            <button type="submit" name="order" class="btn btn-primary"> Siparis Ver </button>
        </form>
    </div>
</div>

<?php

if (isset($_POST["order"]) && !empty($sepet)) {
    if (!isset($_SESSION["user_id"])) {
        echo "<script>alert('Giris Yapiniz!');</script>";
        header("Refresh:0; url=../restaurant-proje/giris-yap.php");
    } else {
        
        unset($_SESSION["sepet"]);
        unset($_SESSION["sepetRestaurantID"]);
        foreach ($urunler as $urunn) {
            $productID = $urunn["product_id"];
            $productName = $urunn["product_name"];
            $product_price = $urunn["product_price"];
            $date = date("Y-m-d H:i:s");
            $userID = $_SESSION["user_id"];
            $restaurantID = $urunn["restaurant_id"];
            $combine_id = $_SESSION["user_id"] . time();
            //mysql
            $sql = "insert into orders(product_id,product_name,product_price,date,user_id,restaurant_id,combine_id) values (?, ?, ?, ?, ?, ?, ?)";
            $sth = $dbconn->prepare($sql);
            $sth->execute([$productID, $productName, $product_price, $date, $userID, $restaurantID, $combine_id]);
        }
        header("Location: sepet.php");
    }

}

?>
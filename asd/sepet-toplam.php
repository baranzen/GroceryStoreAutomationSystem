<?php
require_once("conn.php");

session_start();
$sepet = $_SESSION["sepet"];


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
        $userID = 1;
        $restaurantID = 1;
        $date = date("Y-m-d H:i:s");
        $productsID = "";
        $productsName = "";
        if (count($urunler) > 1) {
            foreach ($urunler as $product) {
                $productsID .= $product["product_id"];
                $productsName .= $product["product_name"];
            }

        } else {
            $productsID = $urunler[0]["product_id"];
            $productsName = $urunler[0]["product_name"];
        }


        $sql = "insert into orders(product_id,product_name,order_total,date,user_id,restaurant_id) values (?, ?, ?, ?, ?, ?)";
        $query = $dbconn->prepare($sql);
        $query->bindParam(1, $productsID, PDO::PARAM_STR);
        $query->bindParam(2, $productsName, PDO::PARAM_STR);
        $query->bindParam(3, $total_price, PDO::PARAM_STR);
        $query->bindParam(4, $date, PDO::PARAM_STR);
        $query->bindParam(5, $_SESSION["user_id"], PDO::PARAM_STR);
        $query->bindParam(6, $restaurantID, PDO::PARAM_STR);
        $insert_result = $query->execute();

        header("Location: sepet.php");
    }

}
?>
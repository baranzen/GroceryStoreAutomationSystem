<?php

require_once("conn.php");

$sql = "select * from products";
$sth = $dbconn->prepare($sql);
$sth->execute();
$urunler = $sth->fetchAll(PDO::FETCH_ASSOC);


?>
<?php
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

    if (isset($_POST["btn"])) {
        session_start();
        $product_id = $_POST["btn"];
        if (!isset($_SESSION["sepet"])) {
            $_SESSION["sepet"] = array();
        }
        array_push($_SESSION["sepet"], $product_id);
        $_SESSION["sepet"] = array_unique($_SESSION["sepet"]);
        /*   print_r($_SESSION["sepet"]); */
    }
}else{
    echo "Ürün bulunmamaktadır.";
}



?>
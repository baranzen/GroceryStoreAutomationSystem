<?php

require_once("../conn.php");

$sql = "select * from products";
$sth = $dbconn->prepare($sql);
$sth->execute();
$urunler = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
<!--  -->
<?php
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
            <form action="#" method="POST">
                <input class="urunler-input" name="productName" type="text" value=" <?php echo $urun_name; ?>">
                <!--     <h5 class="card-title">
                    <?php echo $urun_name; ?> -->
                <input class="urunler-input" name="productPrice" type="text" value=" <?php echo $urun_price; ?>">

                <!-- </h5> -->
                <!--     <p class="card-text">
                    <?php echo $urun_price; ?>
                </p> -->
                <br><br>
                <button type="submit" name="cikar" value="<?php echo $product_id ?>" class="btn btn-primary">Cikar</button>

                <button style="margin-left: 10px;" type="submit" name="guncelle" value="<?php echo $product_id ?>"
                    class="btn btn-primary">Guncelle</button>
            </form>
        </div>

    </div>
    <?php
}
if (isset($_POST["cikar"])) {
    session_start();
    $productID = $_POST["cikar"];
    $sql = "DELETE FROM products WHERE product_id = $productID";
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    header("Location: ../admin/urunler.php");

    $_SESSION["sepet"] = array_diff($_SESSION["sepet"], array($productID));
    header("Location: ../admin/urunler.php");


}

if (isset($_POST["guncelle"])) {
    $product_id = $_POST["guncelle"];
    $product_name = $_POST["productName"];
    $product_price = $_POST["productPrice"];
    $sql = "UPDATE products SET product_name = '$product_name', product_price = '$product_price' WHERE product_id = $product_id";
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    header("Location: ../admin/urunler.php");
}
?>
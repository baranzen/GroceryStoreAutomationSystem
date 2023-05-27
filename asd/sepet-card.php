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
/*  print_r($urunler);  */


?>
<!--  -->
<?php
if ($sepet != null) {
    for ($i = 0; $i < count($urunler); $i++) {
        $urun = $urunler[$i];
        $urun_name = $urun["product_name"];
        $urun_price = $urun["product_price"];
        $urun_image_url = $urun["product_url"];
        $productID = $urun["product_id"];
        ?>

        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src=" <?php echo $urun_image_url; ?>" alt="Card image cap">
            <div class="card-body">
                <form action="#" method="POST">
                    <h5 class="card-title">
                        <?php echo $urun_name; ?>

                    </h5>
                    <p class="card-text">
                        <?php echo $urun_price; ?>
                    </p>
                    <button name="btn" value="<?php echo $productID ?>" class="btn btn-primary">Çıkar</button>
                </form>
            </div>
        </div>

        <?php
    }
}
else{
    echo "Sepetinizde ürün bulunmamaktadır.";
}

if (isset($_POST["btn"])) {

    $product_id = $_POST["btn"];
    $sepet = array_diff($sepet, array($product_id));
    $_SESSION["sepet"] = $sepet;
    header("Location: ../restaurant-proje/sepet.php");
}
?>
<?php
// bu dosyada sepet sessiondaki product_id leri kullanarak ürünleri listeliyoruz.
// böylece kullanıcı ürünlerini sepetten çıkarabiliyor.

// veri tabanı bağlantısı
require_once("conn.php");
// session başlatıyoruz.
session_start();
// sepeti alıyoruz.
$sepet = $_SESSION["sepet"];

// urunler arrayi oluşturuyoruz.
$urunler = array();
/*  burada sepetteki product_id leri gezerek her bir product_id için
 products tablosundan ürün bilgilerini çekip ürünler arrayine atıyoruz. */
// böylece tüm ürünler $ürünler arrayinde oluyor ve listelenmeye hazır hale geliyor.
foreach ($sepet as $id) {
    $sql = "select * from products where product_id = $id";
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    $urun = $sth->fetch(PDO::FETCH_ASSOC);
    // her bir ürünü ürünler arrayine push ediyoruz.
    array_push($urunler, $urun);
}


?>
<!--  -->
<?php
// sepetin boş olup olmadığını kontrol ediyoruz.
if ($sepet != null) {
    // ürünler listesini geziyoruz
    for ($i = 0; $i < count($urunler); $i++) {
        // ürünler arrayini gezerken her bir ürünü $urun değişkenine atıyoruz.
        $urun = $urunler[$i];
        // ürün bilgilerini değişkenlere atıyoruz.
        $urun_name = $urun["product_name"];
        $urun_price = $urun["product_price"];
        $urun_image_url = $urun["product_url"];
        $productID = $urun["product_id"];
        ?>
        <!-- ve html ile ürünleri listeliyoruz -->
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
} else {
    // eğer sepet boşsa bu mesajı gösteriyoruz.
    echo "Sepetinizde ürün bulunmamaktadır.";
}

// sepetten ürün çıkarma işlemi
if (isset($_POST["btn"])) {
    /*      burada sil butonuna basıldığında hangi ürünün silinmesi gerektiğini ayırt 
    edebilmemiz için butondan gelen product_id value değerini post ile çekiyoruz */
    $product_id = $_POST["btn"];
    // sepetten ürünü çıkarıyoruz.
    $sepet = array_diff($sepet, array($product_id));
    // urunun restaurant idsini getiriyoruz.
    $sql = "select restaurant_id from products where product_id = $product_id";
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    $restaurant_id = $sth->fetch(PDO::FETCH_ASSOC)["restaurant_id"];
    // sepetten ürünü çıkardıktan sonra sepetin restaurant id lerinden de çıkarıyoruz.
    $_SESSION["sepetRestaurantID"] = array_diff($_SESSION["sepetRestaurantID"], array($restaurant_id));
    // sepeti güncelliyoruz.
    $_SESSION["sepet"] = $sepet;
    // sepet sayfasına yönlendiriyoruz.
    header("Location: ../restaurant-proje/sepet.php");
}
?>
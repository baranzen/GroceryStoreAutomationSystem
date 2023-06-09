<?php

// bu sayfada adminin eklediği ürünleri gösteriyoruz.
// admin istediği gibi ürün çıkarabilir ve güncelleyebilir.

// veritabanı bağlantısı
require_once("../conn.php");
// session başlatıyoruz.

/* burada admin girişi kontrolü yapıyoruz. eğer admin giriş yapmamışsa
 zaten session admin_id boştur ve boşsa giriş sayfasına yönlendirilir */
session_start();
// isset ile session var mı yok mu kontrol ediyoruz.
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin-giris.php");
}

// admin_id sessionunu alıyoruz.
$resturant_id = $_SESSION["admin_id"];
/*  admin_id ile products tablosundan where ile filtreleme
 yapıyoruz ve restaurantın ürünlerini çekipyoruz. */
$sql = "select * from products where restaurant_id = $resturant_id";
$sth = $dbconn->prepare($sql);
$sth->execute();
// fetchAll ile tüm ürünleri $urunler değişkenine atıyoruz.
$urunler = $sth->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
/* 
burada foreachin aksine for ile urunler listesinin uzunluğu kadar döngüye sokuyoruz.
 */
for ($i = 0; $i < count($urunler); $i++) {
    // burada her bir ürünü $urun değişkenine atıyoruz.
    $urun = $urunler[$i];
    // burada urun değişkeninden ürünlerin bilgilerini payçalıyoruz.
    $urun_name = $urun["product_name"];
    $urun_price = $urun["product_price"];
    $urun_image_url = $urun["product_url"];
    $product_id = $urun["product_id"];
    ?>
    <!-- ve html kodları ile listeliyoruz -->
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
// burada ürün çıkar butonuna basıldığında çalışacak kodlar
if (isset($_POST["cikar"])) {
    // session başlatıyoruz.
    session_start();
    /* burada çıkar butonuna basıldığında hangi ürünün silinmesi gerektiğini ayırt 
    edebilmemiz için butondan gelen product_id value değerini post ile çekiyoruz */
    $productID = $_POST["cikar"];
    // gelen product_id değerine göre products tablosundan ürünü siliyoruz.
    $sql = "DELETE FROM products WHERE product_id = $productID";
    $sth = $dbconn->prepare($sql);
    $sth->execute();

    // ve session sepetten de array_diff ile ürünü çıkarıyoruz.
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
<?php
// bu dosyada sepet sayfasının sağ bloğunda bulunan sepete eklenen ürünlerin listelendiği kısım bulunuyor.

// veri tabanı bağlantısı
require_once("conn.php");

// session başlatıyoruz.
session_start();
/* 
burada restaurant-card.php sayfasından sepete ekle butonuna basıldığında
sepete eklenecek ürünün restaurant idsini içeren session sepetrestaurantID değişkenini
alıyoruz ki kullanıcı birden fazla restauranttan sipariş veremesin.
 */
$restaurantID = $_SESSION["sepetRestaurantID"];
/*  burada birden fazla restaurant idsini içeren session varsa uyarı verip sepetteki ürünleri ve sepetRestaurantID sini unset ile boşaltıyoruz */
if (count($restaurantID) > 1) {
    unset($_SESSION["sepet"]);
    unset($_SESSION["sepetRestaurantID"]);
    echo "<script>alert('Sepette birden fazla restorant var. Lütfen tek restorant seçiniz.');
    window.location.href='../restaurant-proje/index.php';
    </script>";
    header("index.php");
}
/* burada restaurant-card.php sayfasından sepete ekle butonuna basıldığında
sepete eklenecek ürünün idsini içeren session sepet değişkenini
alıyoruz */
// bu değişken sadece ürünlerin product_id sini içeriyor.
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
<div style="display: flex;flex-direction: column;">
    <?php
    // toplam fiyatı hesaplamak için bir değişken oluşturuyoruz.
    $total_price = 0;
    // count($urunler) ile ürünler arrayinin uzunluğunu kadar for döngüsü oluşturuyoruz.
    for ($i = 0; $i < count($urunler); $i++) {
        // her bir ürünü $urun değişkenine atıyoruz.
        $urun = $urunler[$i];
        // ürün bilgilerini değişkenlere atıyoruz.
        $urun_name = $urun["product_name"];
        $urun_price = $urun["product_price"];
        $urun_image_url = $urun["product_url"];
        $productID = $urun["product_id"];
        // toplam fiyatı hesaplıyoruz.
        $total_price += $urun_price;
        ?>
        <!-- ve html ile hesabı sağ blokda listeliyoruz -->
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
        <form method="POST">
            <button type="submit" name="order" class="btn btn-primary"> Siparis Ver </button>
        </form>
    </div>
</div>

<?php
// eğer sipariş ver butonuna basıldıysa ve sepette ürün varsa
if (isset($_POST["order"]) && !empty($sepet)) {
    // eğer kullanıcı girişi yapılmamışsa uyarı verip giriş sayfasına yönlendiriyoruz.
    if (!isset($_SESSION["user_id"])) {
        echo "<script>alert('Giris Yapiniz!');</script>";
        header("Refresh:0; url=../restaurant-proje/giris-yap.php");
    } else {
        // eğer kullanıcı girişi yapılmışsa
        // session başlatıyoruz.
        session_start();
        // sepeti boşaltıyoruz.
        unset($_SESSION["sepet"]);
        // sepetRestaurantID yi boşaltıyoruz.
        unset($_SESSION["sepetRestaurantID"]);
        // ürünler arrayini gezerek her bir ürünün bilgilerini değşkenlere atıyoruz.
        foreach ($urunler as $urunn) {
            $productID = $urunn["product_id"];
            $productName = $urunn["product_name"];
            $product_price = $urunn["product_price"];
            // tarih
            $date = date("Y-m-d H:i:s");
            $userID = $_SESSION["user_id"];
            $restaurantID = $urunn["restaurant_id"];
            /* 
            burada aynı anda birden fazla ürün sipariş edilirse onların  doğrulanması için bir unique combine_id oluşturuyoruz. bunu user_id ve zamanı birleştirerek oluşturuyoruz. böylece aynı anda birden fazla ürün sipariş edilirse bunları birbirinden ayırt edebiliyoruz.
             */
            $combine_id = $_SESSION["user_id"] . time();
            // orders tablosuna sipariş bilgilerini ekliyoruz.
            $sql = "insert into orders(product_id,product_name,product_price,date,user_id,restaurant_id,combine_id) values (?, ?, ?, ?, ?, ?, ?)";
            $sth = $dbconn->prepare($sql);
            //ve değişkenleri sorguya gönderiyoruz.
            $sth->execute([$productID, $productName, $product_price, $date, $userID, $restaurantID, $combine_id]);
        }
        // kullanıcıya sipariş alındı uyarısı verip anasayfaya yönlendiriyoruz.
        echo "<script
        >alert('Siparisiniz Alindi!');
        window.location.href='../restaurant-proje/index.php';
        </script>";
    }

}

?>
<?php
// bu sayfada dinamik olan admin restaurant ismini header a yazdırıyoruz.
// bu işlem birçok sayfada tekrarlandığı için bu sayfaya taşıdık.

// veritabanı bağlantısını dahil ediyoruz.
require_once("../conn.php");
// session başlatma
session_start();
// admin id değerini alıyoruz.
$admin_id = $_SESSION["admin_id"];
// admin id değerine göre admin_name değerini çekiyoruz.
$sql = "select admin_name from admins where restaurant_id = $admin_id";
$sth = $dbconn->prepare($sql);
$sth->execute();
// admin_name değerini $adminnnn değişkenine atıyoruz.
$adminnnn = $sth->fetch(PDO::FETCH_ASSOC)["admin_name"];
?>
<p>
    <?php echo $adminnnn; ?>
</p>
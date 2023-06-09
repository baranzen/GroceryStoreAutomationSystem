<?php
//bu sayfada userın verdiği siparişleri gösteriyoruz.

// session başlatıyoruz.
session_start();
// veritabanı bağlantısı.
require_once("conn.php");
// tarayıcıda depolanan user_id sessionunu alıyoruz.
$sessionID = $_SESSION["user_id"];
// user_id ile orders tablosundan where ile filtreleme yapıyoruz.
// orders çekiyoruz.
$sql = "select * from orders where user_id = $sessionID";
$sth = $dbconn->prepare($sql);
$sth->execute();
/* burada fetchAll ile gelen verileri array olarak alıyoruz sonra da array_reverse 
ile ters çeviriyoruz ki en son eklenen en üstte gözüksün. */
$orders = array_reverse($sth->fetchAll(PDO::FETCH_ASSOC), false);

?>


<?php
/*
    orders tablosundan gelen verileri combine_id değerine göre grupluyoruz.combine_id 
 değeri aynı anda sipariş verilmiş ürünler  bir array içerisine alıyoruz. 
 */
$groupedOrders = array();
foreach ($orders as $order) {
    // combine_id değerini alıyoruz.
    $combineId = $order["combine_id"];
    // 
    if (isset($groupedOrders[$combineId])) {
        // combine_id değeri aynı olanları bir array içerisine alıyoruz.
        $groupedOrders[$combineId][] = $order;
    } else {
        // combine_id değeri aynı olmayanları bir array içerisine alıyoruz.
        $groupedOrders[$combineId] = array($order);
    }
}

// burada da gruplanmış verileri foreach ile döngüye sokuyoruz.
// aynı anda sipariş verilmiş ürünler bir grup olarak gözükecek.
foreach ($groupedOrders as $group) {
    ?>
    <tr>
        <td>
            <?php
            // aynı anda sipariş verilmiş ürünlerin isimlerini birleştiriyoruz.
            $productsName = "";
            foreach ($group as $order) {
                // .= ile birleştiriyoruz.
                $productsName .= $order["product_name"];
                // eğer son ürün değilse virgül koyuyoruz.
                if ($order != end($group)) {
                    $productsName .= ", ";
                }
            }
            echo $productsName;
            ?>
        </td>
        <td>
            <?php echo count($group) ?>
        </td>
        <td>
            <?php
            /* Burada ilk ürünün restaurant idsini çekiyoruz bir grupda birden fazla sipariş verilmiş ise ikisi de aynı yerden sipariş verilmiştir ve bu sorun oluştrmaz
            0 diyoruz çünkü sadece 1 adet ürün de söylenmiş olabilir */
            echo $group[0]["restaurant_id"] ?>
        </td>
        <td>
            <?php 
            // burada yukarıdaki gibi ilk ürünün restaurant idsini çekiyoruz.
            echo $group[0]["date"]; ?>
        </td>
        <td>
            <?php
            // burada ürünlerin toplam fiyatını hesaplıyoruz.
            $orderTotal = 0;
            foreach ($group as $order) {
                $orderTotal += $order["product_price"];
            }
            echo $orderTotal;
            ?>
        </td>
    </tr>
    <?php
}
?>
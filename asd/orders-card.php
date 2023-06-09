<?php
// bu dosyada restaurant a gelen siparişleri admine gösteriyoruz.


// bağlantıyı dahil etme
require_once("../conn.php");
// session başlatma
session_start();
// admin id'sini alıyoruz
$admin_id = $_SESSION["admin_id"];
// admin id'sine göre siparişleri çekiyoruz.
$sql = "select * from orders where restaurant_id = $admin_id";
$sth = $dbconn->prepare($sql);
$sth->execute();
// siparişleri $orders değişkenine atıyoruz.
$orders = $sth->fetchAll(PDO::FETCH_ASSOC);
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
    if (isset($groupedOrders[$combineId])) {
        // combine_id değeri aynı olanları bir array içerisine alıyoruz.
        $groupedOrders[$combineId][] = $order;
    } else {
        // combine_id değeri aynı olmayanları bir array içerisine alıyoruz.
        $groupedOrders[$combineId] = array($order);
    }
}
// burada arrayi ters çeviriyoruz ki en son eklenen en üstte gözüksün.
$groupedOrders = array_reverse($groupedOrders, false);

// burada da gruplanmış verileri foreach ile döngüye sokuyoruz.
foreach ($groupedOrders as $group) {
    // user_id değerini alıyoruz.
    $userID = $group[0]["user_id"];

    /* user_id değerine göre users tablosundan verileri çekiyoruz
    ki siparişi veren kullanıcının adresini ve telefonunu yazabilelim */
    $sql = "select * from users where user_id = $userID";
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    // users tablosundan gelen verileri $user değişkenine atıyoruz.
    $user = $sth->fetch(PDO::FETCH_ASSOC);
    ?>
    <!-- ve html ile sipariş bilgilerini giriyoruz  -->
    <tr>
        <th scope="row">
            <?php echo $group[0]["combine_id"] ?>
        </th>
        <td>
            <?php echo $user["user_name"] ?>
        </td>
        <td>
            <?php echo $user["user_tel"] ?>
        </td>
        <td>
            <p style="width:50%;">
                <?php echo $user["user_adress"] ?>
            </p>
        </td>
        <td>
            <?php
            // burada aynı anda sipariş verilen ürünleri birleştiriyoruz.
            $productsName = "";
            foreach ($group as $order) {
                $productsName .= $order["product_name"];
                // add comma if not last element
                if ($order != end($group)) {
                    // eğer son eleman değilse virgül koyuyoruz.
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
            // fiyatı hesaplıyoruz.
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
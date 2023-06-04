<?php
session_start();
require_once("conn.php");
$sessionID = $_SESSION["user_id"];
$sql = "select * from orders where user_id = $sessionID";
$sth = $dbconn->prepare($sql);
$sth->execute();
$orders = array_reverse($sth->fetchAll(PDO::FETCH_ASSOC), false);

?>


<?php
$groupedOrders = array();
foreach ($orders as $order) {
    $combineId = $order["combine_id"];
    if (isset($groupedOrders[$combineId])) {
        $groupedOrders[$combineId][] = $order;
    } else {
        $groupedOrders[$combineId] = array($order);
    }
}


foreach ($groupedOrders as $group) {
    ?>
    <tr>
        <td>
            <?php
            $productsName = "";
            foreach ($group as $order) {
                $productsName .= $order["product_name"];
                // add comma if not last element
                if ($order != end($group)) {
                    $productsName .= ", ";
                }
            }
            echo $productsName;
            ?>
        </td>
        <td>
            <?php echo count($group)?>
        </td>
        <td>
            <?php echo $order["restaurant_id"]?>
        </td>
        <td>
            <?php echo $group[0]["date"]; ?>
        </td>
        <td>
            <?php
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
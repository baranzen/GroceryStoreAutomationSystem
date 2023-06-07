<?php

require_once("../conn.php");
session_start();
$admin_id = $_SESSION["admin_id"];
$sql = "select * from orders where restaurant_id = $admin_id";
$sth = $dbconn->prepare($sql);
$sth->execute();
$orders = $sth->fetchAll(PDO::FETCH_ASSOC);



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
$groupedOrders = array_reverse($groupedOrders, false);


foreach ($groupedOrders as $group) {
    $userID = $group[0]["user_id"];

    $sql = "select * from users where user_id = $userID";
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    $user = $sth->fetch(PDO::FETCH_ASSOC);
    ?>

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
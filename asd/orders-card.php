<?php

require_once("../conn.php");
$sql = "select * from orders where restaurant_id = 1";
$sth = $dbconn->prepare($sql);
$sth->execute();
$orders = array_reverse($sth->fetchAll(PDO::FETCH_ASSOC), false);



?>

<?php
foreach ($orders as $order) {
    $userID = $order["user_id"];
    $sql = "select * from users where user_id = $userID";
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    $user = $sth->fetch(PDO::FETCH_ASSOC);
    ?>

    <tr>
        <th scope="row">
            <?php echo $order["order_id"] ?>
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
            <?php echo $order["product_name"] ?>
        </td>
        <td>
            <p style="font-style: italic;font-size: large;">
                <?php echo $order["order_total"] . " ₺" ?>
            </p>
        </td>
    </tr>
    <?php
}
?>
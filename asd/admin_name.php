<?php
require_once("../conn.php");
session_start();
$admin_id = $_SESSION["admin_id"];
$sql = "select admin_name from admins where restaurant_id = $admin_id";
$sth = $dbconn->prepare($sql);
$sth->execute();
$adminnnn = $sth->fetch(PDO::FETCH_ASSOC)["admin_name"];
?>
<p>
    <?php echo $adminnnn; ?>
</p>
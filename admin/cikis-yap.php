<form method="POST">
    <button type="submit" name="cikisYap" style="border: none;background-color: transparent;">
        <p style="font-size: medium;margin-left: 20px;color: red;">Cikis yap</p>
    </button>
</form>

<?php
session_start();
if (isset($_POST["cikisYap"])) {
    unset($_SESSION["admin_id"]);
    header("Location: admin-giris.php");
}
?>
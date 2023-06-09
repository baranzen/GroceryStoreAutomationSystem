<!-- headerdaki çıkış yap butonu
bunu bir dosyaya aldık ve her sayfada kullanmak için require ettik. -->

<form method="POST">
    <button type="submit" name="cikisYap" style="border: none;background-color: transparent;">
        <p style="font-size: medium;margin-left: 20px;color: red;">Cikis yap</p>
    </button>
</form>

<?php
// çıkış yap butonuna basınca sessionu siliyoruz ve admin-giris.php sayfasına yönlendiriyoruz.
session_start();
if (isset($_POST["cikisYap"])) {
    unset($_SESSION["admin_id"]);
    header("Location: admin-giris.php");
}
?>
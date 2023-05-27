<?php
session_start();
// user session bos ise
if (!isset($_SESSION["user_id"])) {
    ?>
    <a href="giris-yap.php">
        <button style="margin-right: 5px;" type="button" class="btn btn-primary">
            Giris Yap
        </button>
    </a>

    <a href="kayit-ol.php">
        <button type="button" class="btn btn-primary">
            Kayit Ol
        </button>
    </a>

    <?php
} else {
    ?>
    <div class="dropdown" style="margin-right: 10px;">
        <button class="btn btn-secondary dropdown-toggle basket" type="button" id="dropdownMenuButton"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-user" style="color: #ffffff;"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a href="bilgilerim.php">
                <button class="dropdown-item" href="#">Bilgilerim</button>
            </a>
            <form action="#" method="POST">
                <button type="submit" name="logOut" class="dropdown-item" href="#">Oturumu kapat</button>
            </form>
        </div>
    </div>
    <?php
}
if (isset($_POST["logOut"])) {
    // user_id session'ı silinir
    unset($_SESSION["user_id"]);
    header("Location: index.php");
}
?>
<?php
// bu sayfada dinamik olan butonlarımızın kontrolünü yapıyoruz.
// ve clean code olması için header_buttons.php dosyasına taşıdık.
// bu işlem birçok sayfada tekrarlandığı için bu sayfaya taşıdık.
// session başlatma
session_start();

// eğer kullanıcı giriş yapmamışsa giriş yap ve kayıt ol butonlarını gösteriyoruz.
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
    // eğer kullanıcı giriş yapmışsa bilgilerim ve çıkış yap butonlarını gösteriyoruz.
    // ayrıca kullanıcı adını da yazdırıyoruz ve bir user iconu ekliyoruz.

    // veritabanı bağlantısını dahil ediyoruz.
    require_once("conn.php");
    // user id değerini alıyoruz.
    $userID = $_SESSION["user_id"];
    // user id değerine göre users tablosundan verileri çekiyoruz.
    $query = $dbconn->prepare("SELECT * FROM users WHERE user_id = ?");
    $query->execute([$userID]);
    // users tablosundan gelen verileri $userInformation değişkenine atıyoruz.
    $userInformation = $query->fetch(PDO::FETCH_ASSOC);

    ?>
    <div class="dropdown" style="margin-right: 10px;">
        <button class="btn btn-secondary dropdown-toggle basket" type="button" id="dropdownMenuButton"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php
            /* burada eğer owner tablosundaki user_id ile sessiondaki user_id eşleşiyorsa
            admin olarak cıvata anahtarı ikonu gösteriyoruz , eğer eşleşmiyorsa
            user ikonu gösteriyoruz */
            $sql = "select * from owner";
            $sth = $dbconn->prepare($sql);
            $sth->execute();
            $owner = $sth->fetchAll(PDO::FETCH_ASSOC);
            $owner_id = $owner[0]["user_id"];
            if ($_SESSION["user_id"] != $owner_id) {
                ?>
                <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                <?php
            } else {
                ?>
                <i class="fa-solid fa-screwdriver-wrench"></i>
                <?php
            }
            ?>

            <label style="margin-left: 5px;">
                <?php echo $userInformation["user_name"] ?>
            </label>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a href="bilgilerim.php">
                <button class="dropdown-item">Bilgilerim</button>
            </a>
            <a href="siparislerim.php">
                <button class="dropdown-item">Siparislerim</button>
            </a>
            <?php
            /* burada eğer owner tablosundaki user_id ile sessiondaki user_id eşleşiyorsa
                      yönetici panel kısmını dropdown a ekliyoruz */
            $sql = "select * from owner";
            $sth = $dbconn->prepare($sql);
            $sth->execute();
            $owner = $sth->fetchAll(PDO::FETCH_ASSOC);
            $owner_id = $owner[0]["user_id"];
            if ($_SESSION["user_id"] == $owner_id) {


                ?>
                <div style="background-color: #aacb73;">
                    <a href="yonetici.php">
                        <button class="dropdown-item" style="color: #FFFFE8;">
                            <i class="fa-solid fa-unlock"></i>
                            Yonetici Panel
                        </button>
                    </a>
                </div>

                <?php
            }
            ?>
            <form action="#" method="POST">
                <button type="submit" name="logOut" class="dropdown-item" href="#">Oturumu kapat</button>
            </form>
        </div>
    </div>
    <?php
}

// logout işlemi
if (isset($_POST["logOut"])) {
    // user_id session'ı silinir
    unset($_SESSION["user_id"]);
    // oturum kapatılır ve index.php'ye yönlendirilir.
    header("Location: index.php");
}

?>
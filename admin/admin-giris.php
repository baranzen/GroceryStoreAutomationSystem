<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Getirme | Anasayfa </title>
    <link rel="stylesheet" href="../reset.css">
    <link rel="stylesheet" href="../index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a20f77a62b.js" crossorigin="anonymous"></script>
</head>

<body>

    <header>

        <a href="../admin/">
            <div class="site-logo"></div>
        </a>

    </header>

    <main>
        <h1>Admin Giris Yap</h1>

        <form action="#" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Ad</label>
                <input name="name" type="text" class="form-control" required id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Ad">
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputPassword1">Sifre</label>
                <input name="password" type="password" required class="form-control" id="exampleInputPassword1"
                    placeholder="Sifre">
            </div><br>
            <button type="submit" name="girisYap" class="btn btn-primary">Giris Yap</button>
        </form>
    </main>

    <footer style="position: absolute;bottom: 0;"></footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>

<?php

// veritabanı bağlantısı
require_once("../conn.php");

// eğer formdan giriş yap butonuna basıldıysa
if (isset($_POST["girisYap"])) {
    //session başlat
    session_start();
    // post ile html nametaglerinden gelen name ve password değerlerini alıyoruz.
    $name = $_POST["name"];
    // şifreyi md5 ile şifreleyiyoruz.
    $password = md5($_POST["password"]);

    // veritabanından gelen name ve password değerlerini kontrol ediyoruz.
    // burada post ile gelen şifre hem veritabanında hem de sessionda md5 ile şifrelenmiş olduğu için bir sıkıntı olmuyor.
    $query = $dbconn->prepare("SELECT * FROM admins WHERE admin_name = ? AND admin_password = ?");
    $query->execute([$name, $password]);
    // eğer veritabanında böyle bir kullanıcı varsa sessiona admin_id yi atıyoruz ve admin paneline yönlendiriyoruz.
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $_SESSION["admin_id"] = $result["restaurant_id"];
        header("Refresh:0; url=../admin/");
    } else {
        echo "<script>alert('Giris Basarisiz!');</script>";
    }
}
?>
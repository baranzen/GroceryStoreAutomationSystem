<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Getirme | Anasayfa </title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a20f77a62b.js" crossorigin="anonymous"></script>
</head>

<body>

    <header>
        <a href="../restaurant-proje/">
            <div class="site-logo"></div>
        </a>
        <div class="buttons">

            <?php
            // clean code için header_buttons.php dosyası oluşturuldu.
            require_once("asd/header_buttons.php"); ?>
        </div>
    </header>

    <main>
        <h1>Giris Yap</h1>

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
// veritabanı bağlantısı.
require_once("conn.php");

// giris yapma işlemi.
// giriş yap butonu basılınca tetiklenir.
if (isset($_POST["girisYap"])) {
    // session başlatılır.
    session_start();

    // post ile html içerisindeki name taglerinin değerlerini alıyoruz.
    $name = $_POST["name"];
    $password = md5($_POST["password"]);
    // sql sorgusu ile veritabanından kullanıcı adı ve şifre kontrolü yapılır.
    $query = $dbconn->prepare("SELECT * FROM users WHERE user_name = ? AND user_password = ?");
    // burada değişkenleri sırayla yazıyoruz.
    $query->execute([$name, $password]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    // eğer kullanıcı adı ve şifre doğruysa sessiona user_id değeri atanır ve anasayfaya yönlendirilir ki session sayesinde her penrede kullanıcı giriş yapmış gözüksün.
// eğer kullanıcı adı ve şifre yanlışsa hata mesajı verilir.
    if ($result) {
        $_SESSION["user_id"] = $result["user_id"];
        header("Refresh:0; url=../restaurant-proje/");
    } else {
        echo "<script>alert('Giris Basarisiz!');</script>";
    }

}

?>
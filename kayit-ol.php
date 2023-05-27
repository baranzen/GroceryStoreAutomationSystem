<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Getirme | Kayit Ol</title>
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
            <?php require_once("asd/header_buttons.php"); ?>
        </div>
    </header>

    <main>
        <h1>Kayit Ol</h1>

        <form action="#" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Ad</label>
                <input name="name" type="text" class="form-control" required id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Ad">
            </div>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">Soyad</label>
                <input name="surName" type="text" required class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Soyad">
            </div><br>
            <div class="form-group">
                <label for="exampleInputPassword1">Sifre</label>
                <input name="password" type="password" required class="form-control" id="exampleInputPassword1"
                    placeholder="Sifre">
            </div><br>
            <div class="form-group">
                <label for="exampleInputPassword1">Telefon</label>
                <input name="number" type="password" required class="form-control" id="exampleInputPassword1"
                    placeholder="Telefon numarasi">
            </div><br>
            <div class="form-group">
                <label for="exampleInputPassword1">Adres</label>
                <textarea name="adress" required class="form-control" id="exampleInputPassword1" placeholder="Adres"
                    cols="30" rows="3"></textarea>
            </div><br>
            <button type="submit" name="kayitOl" class="btn btn-primary">Kayit Ol</button>
        </form>
    </main>

    <footer style="position: absolute;bottom: 0;"></footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>

<?php

require_once("conn.php");

if (isset($_POST['kayitOl'])) {
    $name = $_POST['name'];
    $surName = $_POST['surName'];
    $password = md5($_POST['password']);
    $number = $_POST['number'];
    $adress = $_POST['adress'];

    $sql = "insert into users(user_name,user_surname,user_password,user_tel,user_adress) values(?,?,?,?,?)";

    $query = $dbconn->prepare($sql);

    $query->bindParam(1, $name, PDO::PARAM_STR);
    $query->bindParam(2, $surName, PDO::PARAM_STR);
    $query->bindParam(3, $password, PDO::PARAM_STR);
    $query->bindParam(4, $number, PDO::PARAM_STR);
    $query->bindParam(5, $adress, PDO::PARAM_STR);

    $insert_result = $query->execute();

    if ($query) {
        header("Location: giris-yap.php");
    } else {
        echo "Kayit olunamadi";
    }
}

?>
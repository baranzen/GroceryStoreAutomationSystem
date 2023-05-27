<?php
session_start();
require_once("conn.php");
$userID = $_SESSION["user_id"];
$query = $dbconn->prepare("SELECT * FROM users WHERE user_id = ?");
$query->execute([$userID]);
$userInformation = $query->fetch(PDO::FETCH_ASSOC);

$userName = $userInformation["user_name"];
$userSurname = $userInformation["user_surname"];
$userPassword = $userInformation["user_password"];
$userTel = $userInformation["user_tel"];
$userAdress = $userInformation["user_adress"];
?>

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
            <?php require_once("asd/header_buttons.php"); ?>

            <a href="sepet.php">
                <button class="basket">
                    <i class="fa-solid fa-basket-shopping" style="color: #FFFFE8;"></i>
                </button>
            </a>

        </div>
    </header>

    <main>
        <h1>Bilgilerim</h1>

        <form method="POST">

            <div class="form-group">
                <label for="exampleInputEmail1">Ad</label>
                <input name="name" type="text" class="form-control" required id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Ad" value="<?php echo $userName ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Soyad</label>
                <input name="surname" type="text" class="form-control" required id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Soyad" value="<?php echo $userSurname ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Sifre</label>
                <input name="password" type="password" required class="form-control" id="exampleInputPassword1"
                    placeholder="Sifre">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Tel</label>
                <input name="tel" type="tel" required class="form-control" id="exampleInputPassword1" placeholder="Tel"
                    value="<?php echo $userTel ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Adres</label>
                <textarea name="adress" required class="form-control" id="exampleInputPassword1" placeholder="Adres"
                    cols="30" rows="3"><?php echo $userAdress ?></textarea>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Guncelle</button>
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
if (isset($_POST["update"])) {

    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $tel = $_POST["tel"];
    $adress = $_POST["adress"];

    $query = $dbconn->prepare("UPDATE users SET user_name = ?, user_surname = ?, user_tel = ?, user_adress = ? WHERE user_id = ?");
    $query->execute([$name, $surname, $tel, $adress, $userID]);
    if ($query) {
        echo "<script>window.location.href='bilgilerim.php';</script>";
    } else {
        echo "bir hata olustu";
    }
}

?>
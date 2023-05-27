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
        <a href="../admin">
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
require_once("../conn.php");

if(isset($_POST["girisYap"])){
    session_start();
    $name = $_POST["name"];
    $password = $_POST["password"];
    

    $query = $dbconn->prepare("SELECT * FROM admins WHERE admin_name = ? AND admin_password = ?");
    $query->execute([$name, $password]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $_SESSION["admin_id"] = $result["admin_id"];
        header("Refresh:0; url=../admin/");
    } else {
        echo "<script>alert('Giris Basarisiz!');</script>";
    }
}
?>
<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin-giris.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Getirme | Admin </title>
    <link rel="stylesheet" href="../reset.css">
    <link rel="stylesheet" href="../index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a20f77a62b.js" crossorigin="anonymous"></script>
</head>

<body>

    <header>
        <a href="../">
            <div class="site-logo"></div>
        </a>


        <div style="display: flex;flex-direction: row;justify-content: center;align-items: center;">
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
            <?php require_once("cikis-yap.php"); ?>
        </div>

    </header>

    <main>
        <h1>Yeni Urun Ekle</h1>
        <main>

            <form action="#" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Urun Adi</label>
                    <input required type="text" name="productName" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Urun Adi giriniz...">
                </div>
                <br>
                <div class="form-group">
                    <label for="exampleInputPassword1">Urun Fiyati</label>
                    <input required type="text" name="productPrice" class="form-control" id="exampleInputPassword1"
                        placeholder="Urun fiyati...">
                </div>
                <br>
                <div class="form-group">
                    <label for="exampleInputPassword1">Urun Gorsel Url</label>
                    <input required type="text" name="productUrl" class="form-control" id="exampleInputPassword1"
                        placeholder="Urun gorsel url...">
                </div>
                <br>
                <div style="text-align: center;margin-top: 30px;">
                    <input required style="width: 20%;" name="btn" type="submit"
                        class="btn btn-primary btn-lg btn-block" value="Urun Ekle">
                </div>
            </form>


        </main>
    </main>

    <footer></footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>

<?php

require_once("../conn.php");

if (isset($_POST["btn"])) {
    $productName = $_POST["productName"];
    $productPrice = $_POST["productPrice"];
    $productUrl = $_POST["productUrl"];

    $sql = "insert into products(product_name,product_price, product_url,restaurant_id)values(?,?,?,?)";

    $query = $dbconn->prepare($sql);

    $query->bindParam(1, $productName, PDO::PARAM_STR);
    $query->bindParam(2, $productPrice, PDO::PARAM_STR);
    $query->bindParam(3, $productUrl, PDO::PARAM_STR);
    $query->bindParam(4, $_SESSION["admin_id"], PDO::PARAM_STR);

    $insert_result = $query->execute();

    echo "<script>alert('Urun basariyla eklendi!')</script>";
}

?>
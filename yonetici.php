<?php
// veri tabanı bağlantısı
require_once("conn.php");
// session başlatma
session_start();

/* 
Yönetici sayfası doğrulama işlemi.
Burada yapılan işlem: veri tabanında owner tablosunda oluşturulan yonetici 
id si ilen sessionda tutulan user id eşit ise yonetici.php sayfasına erişim sağlanır.
 Eğer eşit değil ise anasayfaya yönlendirilir.
 */
$sql = "select * from owner";
$sth = $dbconn->prepare($sql);
$sth->execute();
$owner = $sth->fetchAll(PDO::FETCH_ASSOC);
$owner_id = $owner[0]["user_id"];
$owner_id == $_SESSION["user_id"] ? $owner_id : header("Refresh:0; url=../restaurant-proje/");
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
    <link rel="stylesheet" href="../restaurant-proje/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a20f77a62b.js" crossorigin="anonymous"></script>

    <style>
        .yonetici-container {
            display: flex;
            flex-direction: row;

            width: 100%;
        }

        .yonetici-container div {
            width: 49%;
            background-color: #FFFFE8;
            padding: 15px;
            border-radius: 10px;
        }
    </style>
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
        <div class="yonetici-container">
            <div>
                <h1>Restorant Ekle</h1>
                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Restorant Adi</label>
                        <input name="restaurantName" type="text" class="form-control" required id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Ad">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Restorant Sifre</label>
                        <input name="restaurantPassword" type="password" class="form-control" required
                            id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ad">
                    </div>

                    <button type="submit" name="addRestaurant" class="btn btn-primary">Ekle</button>
                </form>
            </div>
            <div style="margin-left: 2%;">

                <h1>Restorantlar</h1>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Restorant Adi</th>
                        </tr>
                    </thead>
                </table>
                <?php
                /* 
                Burada yapılan işlemde: yöneticinin eklediği restoranları
                 veri tabanından çekip foreach ile ekrana yazdırıyoruz.
                 */
                require_once("conn.php");
                $sql = "select * from restaurants";
                $sth = $dbconn->prepare($sql);
                $sth->execute();
                $restaurants = $sth->fetchAll(PDO::FETCH_ASSOC);
                foreach ($restaurants as $restaurant) {
                    ?>

                    <div style="display: flex;flex-direction: row;">
                        <?php echo $restaurant["restaurant_name"]; ?>
                        <form action="#" method="POST">
                            <button type="submit" name="removeRestaurant"
                                style="background-color: transparent;border: none;"
                                value="<?php echo $restaurant["restaurant_id"] ?>">
                                <i class="fa-regular fa-trash-can" style="font-size: 18px;color:#AACB73"></i>
                            </button>
                        </form>
                    </div>

                    <?php
                }
                ?>
            </div>
        </div>
    </main>

    <footer>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>


<?php
// restoran ekleme işlemi
// Ekle butonuna basıldığında tetıklenir.
if (isset($_POST["addRestaurant"])) {
    // post ile html içerisindeki name taglerinin değerlerini alıyoruz.
    $restaurantName = $_POST["restaurantName"];
    $restaurantPassword = md5($_POST["restaurantPassword"]);
    // restaurants tablosuna restoran ekliyoruz.
    $sql = "insert into restaurants (restaurant_name) values ('$restaurantName')";
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    // restoran ekledikten sonra restoranın id sini alıyoruz.
    $sql = "select * from restaurants where restaurant_name = '$restaurantName'";
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    $restaurant = $sth->fetchAll(PDO::FETCH_ASSOC);
    /*     restoran id sini kullanarak admin tablosuna restoranın 
    yöneticisini ekliyoruz böylece admin panelıne giriş yapabilecek. */
    $restaurantID = $restaurant[0]["restaurant_id"];
    $sql = "insert into admins (admin_name,admin_password,restaurant_id) values ('$restaurantName','$restaurantPassword',$restaurantID)";
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    // işlem bittikten sonra sayfayı yeniliyoruz.
    header("Refresh:0; url=../yonetici.php/");
}
// restoran silme işlemi
// sil butonuna basıldığında tetıklenir.
if (isset($_POST["removeRestaurant"])) {
    /*      burada sil butonuna basıldığında hangi restorantın silinmesi gerektiğini ayırt 
    edebilmemiz için butondan gelen restaurant_id value değerini post ile çekiyoruz */
    $restaurantID = $_POST["removeRestaurant"];
    // restorantı resutraunts tablosundan butondan gelen id ile eşleşen stünu siliyoruz.
    $sql = "delete from restaurants where restaurant_id = $restaurantID";
    $sth = $dbconn->prepare($sql);
    $sth->execute();
    // sayfayı yeniliyoruz.
    header("Refresh:0; url=../yonetici.php");
}
?>
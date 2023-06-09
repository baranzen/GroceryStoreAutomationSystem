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


</head>

<body>


    <header>
        <a href="../restaurant-proje/">
            <div class="site-logo"></div>
        </a>
        <div class="buttons">
            <?php
            // clean code için header_buttons.php dosyası oluşturuldu.
            require_once("asd/header_buttons.php");
            ?>

            <a href="sepet.php">
                <button class="basket">
                    <i class="fa-solid fa-basket-shopping" style="color: #FFFFE8;"></i>
                </button>
            </a>

        </div>
    </header>

    <div class="slider">
        <div>
            <div class="slider-logo">
                <img src="assets/logo2.png" alt="">
            </div>
        </div>

        <div>
            <div class="slider-logo">
                <img src="assets/down_arrow.png" alt="">
            </div>
        </div>
        <div>
            <div class="slider-logo">
                <img src="assets/slider.png" alt="">
            </div>
        </div>
    </div>

    <main>
        <?php
        // clean code için restaurant-card.php dosyası oluşturuldu.
        require_once("asd/restaurant-card.php");
        ?>

    </main>

    <footer>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>
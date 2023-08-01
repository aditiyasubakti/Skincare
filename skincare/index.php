<?php
session_start();
error_reporting(E_ALL);

function countNameOccurrences($filename, $nama)
{
    $data = file_get_contents($filename);
    $dataArray = unserialize($data);

    $count = 0;
    foreach ($dataArray as $data) {
        if ($data['username'] === $nama) {
            $count++;
        }
    }

    return $count;
}

function readDataFromDB($filename)
{
    $data = file_get_contents($filename);
    $dataArray = unserialize($data);

    return $dataArray;
}
if (isset($_SESSION['login'])) {
    $SessionName = $_SESSION['nama'];
    $SessionUsername = $_SESSION['username'];
    $jumlahKemunculan = countNameOccurrences('database/beli/produc.txt', $_SESSION['username']);
} else {
    $SessionName = "";
    $SessionUsername = "";
    $jumlahKemunculan = 0;
}
$database1 = [];
$pd = 'database/beli/produc.txt';
if (file_exists($pd)) {
    $database1 = readDataFromDB($pd);
}

$database = [];
$filename = 'database/produc/produc.txt';
if (file_exists($filename)) {
    $database = readDataFromDB($filename);
}

$url = isset($_SESSION['login']) && $_SESSION['login'] === true ? "produc.php" : "login.html";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skincare</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <a class="navbar-brand text-white" href="#">Skincare</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="./">Beranda</a>
                </li>
                <?php if (isset($_SESSION['username']) && $_SESSION['username'] == "ayu") : ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="dashboard.php">dashboard</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="cartDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-shopping-cart">
                            <img src="img/ikon/trolli-white.png" class="cart-icon">
                            <span class="cart-count"><?= $jumlahKemunculan ?></span>
                        </i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="cartDropdown">
                        <?php foreach ($database1 as $beli) : ?>
                            <?php if ($beli['username'] == $SessionUsername) : ?>
                                <div class="dropdown-item">
                                    <div class="item-wrapper">
                                        <img src="img/produc/<?= $beli['gambar'] ?>" alt="Produk 1" class="item-image">
                                        <div class="item-info">
                                            <h6 class="item-name"><?= $beli['namab'] ?></h6>
                                            <p class="item-price"><?= $beli['hargab'] ?></p>
                                        </div>
                                        <form action="delete.php" method="post" class="item-form">
                                            <input type="hidden" name='id' value="<?= $beli['id'] ?>">
                                            <button type="submit" class="btn btn-danger">delete</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </li>
                <?php if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.html"><img src="img/ikon/user.png" class="user-icon"></a>
                    </li>
                <?php else : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link " href="" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="img/ikon/user.png" class="user-icon"><?= $SessionName ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">Profile</a>
                            <a class="dropdown-item" href="#">Settings</a>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Jumbotron -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/scarlet.jpg" class="d-block w-100 img-fluid" alt="Gambar 1">
            </div>
            <div class="carousel-item">
                <img src="img/ponds.jpeg" class="d-block w-100 img-fluid" alt="Gambar 2">
            </div>
            <div class="carousel-item">
                <img src="img/maskulin.jpg" class="d-block w-100 img-fluid" alt="Gambar 3">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="container">
        <!-- Daftar Produk -->
        <div class="mt-4">
            <h2 class="pesan-title">Daftar Produk Skincare</h2>
            <hr>
            <div class="row">
                <?php foreach ($database as $data) : ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card mb-3">
                            <form action="<?= $url ?>" method="post">
                                <input type="hidden" name="username" value="<?= $SessionUsername ?>">
                                <input type="hidden" name="namap" value="<?= $SessionName ?>">
                                <input type="hidden" name="namab" value="<?= $data['namab'] ?>">
                                <input type="hidden" name="hargab" value="<?= $data['harga'] ?>">
                                <input type="hidden" name="gambar" value="<?= $data['gambar'] ?>">
                                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                <input type="hidden" name="count" value="1">
                                <button class="link-produc" type="submit" name="addToCart">
                                    <img src="img/produc/<?= $data['gambar'] ?>" class="card-img-top" alt="Produk 1">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $data['namab'] ?></h5>
                                        <p class="card-text">Rp.<?= number_format($data['harga'], 0, ',', '.') ?></p>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
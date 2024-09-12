<?php
    require_once('phpSrc.php'); 
    session_start();

    $dsn = 'mysql:host=sql113.lh.pl;dbname=serwer244499_geek;charset=utf8mb4';
    $username = 'serwer244499';
    $password = 'Kamil123#$#';

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_GET['id'])) {
            $product_id = $_GET['id'];

            $query = "SELECT * FROM products WHERE product_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            // Sprawdzenie czy produkt został znaleziony
            if ($product) {
                $name = htmlspecialchars($product['name']);
                $price = htmlspecialchars($product['price']);
                $description = htmlspecialchars($product['description']);

            } else {
                echo "Product not found.";
                exit();
            }
        } 
        else {
            echo "No product ID provided.";
            exit();
        }
    } 
    catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    
    if (isset($_POST['add'])) {
        $id_produktu = $product_id;

        if (isset($_SESSION['cart'][$id_produktu])) {
        // Produkt już istnieje w koszyku zwieksz ilość
        $_SESSION['cart'][$id_produktu]['quantity']++;
        header("Location: cart.php");
        } else {
        // Dodaj do koszyka
        $_SESSION['cart'][$id_produktu] = array(
            'id_produktu' => $id_produktu,
            'quantity' => 1
        );
        header("Location: cart.php");
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./img/favicon-32x32.png">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./style-carousel.css">
    <link rel="stylesheet" href="./style-main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <title><?php echo htmlspecialchars($product['name']); ?></title>
</head>
<body>
    <div id="div">
        <header class="mb-4 bg-dark">
            <div class="p-4 text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 d-flex justify-content-center justify-content-md-start justify-content-xl-start mb-3 mb-md-0">
                            <a href="./index.php" class="ms-md-3">
                                <img src="./img/geekit_orange_logo_white_text.png" height="35"></a>
                        </div>

                        <div class="col-md-4">
                            <form class="d-flex input-group w-auto my-auto mb-3 mb-md-0" id="searchForm">
                                <input autocomplete="off" type="search" class="form-control rounded" placeholder="Search" id="searchInput" />
                            </form>
                            <ul id="searchResults" class="list-group mt-2"></ul>
                        </div>

                        <style>
                            #searchResults {
                                position: absolute;
                                z-index: 1000;
                                background-color: #212529;
                                border: 2px solid #212529;
                                width: calc(100% - 40px);
                                max-height: 200px;
                                overflow-y: auto;
                                margin-top: 40px;
                                margin-left: 5px;
                            }
                        </style>

                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                $('#searchInput').on('input', function() {
                                    var query = $(this).val();

                                    $.ajax({
                                        type: 'GET',
                                        url: 'search.php',
                                        data: {
                                            query: query
                                        },
                                        success: function(response) {
                                            if (query !== '') {
                                                $('#searchResults').html(response).addClass('show');
                                            } else {
                                                $('#searchResults').html('').removeClass('show');
                                            }
                                        }
                                    });
                                });
                            });
                        </script>


                        <div class="col-md-4 d-flex justify-content-center justify-content-md-end align-items-center">
                            <div class="d-flex">
                                <a class="text-white me-5" href="./login.php">
                                    <span><i class="fa-solid fa-user display-5"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <nav id="menu">
                <ul>
                    <li><a href="./cart.php" class="fa-solid fa-cart-shopping cart-icon">Cart</a></li>
                </ul>
            </nav>

            <div id="menu-toggle" class="_menu"><img src="./img/menu-2.svg" width="40px"></div>

            <script>
                var menu = document.getElementById('menu');
                var menuToggle = document.getElementById('menu-toggle');

                menu.style.left = '-250px';

                menuToggle.addEventListener('click', function() {
                    if (menu.style.left === '-250px')
                        menu.style.left = '0';
                    else
                        menu.style.left = '-250px';
                });
            </script>
        </header>
    </div>

    <section class="py-5 text-white">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6">
                    <?php
                    $image = '<img class="card-img-top mb-5 mb-md-0" style="object-fit: contain; height: 450px; width: 100%;" 
                            src="data:image/jpeg;base64,' . base64_encode($product['photo']) . '" alt="' . htmlspecialchars($product['name']) . '"/>';
                    echo $image;
                    ?></div>
                <div class="col-md-6">
                    <h1 class="display-5 fw-bolder text-warning"><?php echo htmlspecialchars($product['name']); ?></h1>
                    <div class="fs-5 mb-5 text-info">
                        <span class="display-6">$<?php echo htmlspecialchars($product['price']); ?></span>
                    </div>
                    <p class="lead text-white"><?php echo htmlspecialchars($product['description']); ?></p>
                    <div class="d-flex">
                        <form action='' method='post'>
                            <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1" style="max-width: 5rem" name="quantityValue">
                            <button class='fa fa-shopping-cart cart-add-product' type='submit' name='add'></button>	
                            <input type='hidden' name='product_id' value='$product_id'>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-dark">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4 text-white">Related products</h2>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                    $connect = new mysqli('sql113.lh.pl', 'serwer244499', 'Kamil123#$#', 'serwer244499_geek');
                    if ($connect->connect_error)
                        echo "Error" . $connect;

                    // Funkcja pobierająca losowe produkty z bazy danych
                    function getRandomData($connect){
                        $query = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
                        $result = mysqli_query($connect, $query);
                        return $result;
                    }

                    $result = getRandomData($connect);

                    while ($row = mysqli_fetch_assoc($result)) {
                        display($row['name'], $row['price'], $row['photo'], $row['product_id']);
                    }

                    mysqli_close($connect);
                ?>
            </div>
        </div>
    </section>

    <footer class="py-3 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Geek-it 2024</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
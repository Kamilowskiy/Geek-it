<?php require_once('phpSrc.php'); ?>
<?php
session_start();

if (isset($_POST['add'])) {
	$id_produktu = $_POST['product_id'];

	if (isset($_SESSION['cart'][$id_produktu])) {
		// Produkt już istnieje w koszyku, zwiększ ilość
		$_SESSION['cart'][$id_produktu]['quantity']++;
		header("Location: cart.php");
	} 
  else {
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
  <script type="text/javascript" src="./script.js"></script>
  <title>Geek-it</title>
</head>

<body>
  <div id="div">
    <header class="mb-4 bg-dark">
      <div class="p-4 text-center">
        <div class="container">
          <div class="row">
            <div class="col-md-4 d-flex justify-content-center justify-content-md-start justify-content-xl-start mb-3 mb-md-0">
              <a href="./index-logged.php" class="ms-md-3">
                <img src="./img/geekit_orange_logo_white_text.png" height="35" />
              </a>
            </div>

            <div class="col-md-4">
              <form class="d-flex input-group w-auto my-auto mb-3 mb-md-0" id="searchForm">
                <input autocomplete="off" type="search" class="form-control rounded" placeholder="Search" id="searchInput" />
              </form>
              <ul id="searchResults" class="list-group mt-2"></ul>
            </div>


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

            <style>
              #searchResults {
                position: absolute;
                z-index: 1000;
                background-color: #212529;
                border: 2px solid #212529;
                width: calc(100% - 30px);
                max-height: 200px;
                overflow-y: auto;
                margin-top: 40px;
              }
            </style>


            <div class="col-md-4 d-flex justify-content-center justify-content-md-end align-items-center">
              <div class="d-flex">
                <a class="text-white me-5" href="./login.php">
                  <span><i class="fa-solid fa-user display-5"></i></span>
                  <!-- <span class="badge rounded-pill badge-notification bg-danger">1</span> -->
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <nav id="menu">
        <ul>
          <li><a href="./cart.php"><i class="fa-solid fa-cart-shopping cart-icon"></i>Cart</a></li>
          <li><a href="#">Categories</a></li>
          <li><a href="#">Contact</a></li>
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
  </div>

  <div id="carouselFade" class="carousel slide carousel-fade" data-ride="carousel">
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <div class="carousel-caption">
          <h3></h3>
          <p></p>
        </div>
      </div>

      <div class="item">
        <div class="carousel-caption">
          <h3></h3>
          <p></p>
        </div>
      </div>

      <div class="item">
        <div class="carousel-caption">
          <h3></h3>
          <p></p>
        </div>
      </div>
    </div>

    <a class="left carousel-control" href="#carouselFade" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carouselFade" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  <script>
    $('#carouselFade').carousel();
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

  <main class="container">
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 justify-content-center">
      <?php
        $result = getData();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          display($row['name'], $row['price'], $row['photo'], $row['product_id']);
        }
      ?>
    </div>
  </main>
  <footer class="py-3 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Geek-it 2024</p>
    </div>
  </footer>
</body>

</html>
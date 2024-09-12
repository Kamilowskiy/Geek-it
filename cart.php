<?php
	require_once('phpSrc.php');
	session_start();

	if (isset($_POST['remove'])) {
		if ($_GET['action'] == 'remove') {
			foreach ($_SESSION['cart'] as $key => $value) {
				if ($value["id_produktu"] == $_GET['id']) {
					unset($_SESSION['cart'][$key]);
				}
			}
		}
	}

	if (isset($_POST['add']) || isset($_POST['subtract'])) {
		$product_id = $_GET['id'];
		$action = isset($_POST['add']) ? 'add' : 'subtract';

		if (isset($_SESSION['cart'][$product_id])) {
			if ($action === 'add') {
				$_SESSION['cart'][$product_id]['quantity']++;
			} 
			elseif ($action === 'subtract') {
				if ($_SESSION['cart'][$product_id]['quantity'] > 1) {
					$_SESSION['cart'][$product_id]['quantity']--;
				} 
				else {
					foreach ($_SESSION['cart'] as $key => $value) {
						if ($value["id_produktu"] == $_GET['id']) {
							unset($_SESSION['cart'][$key]);
						}
					}
				}
			}
		}
	}
	

	// Obsługa wyboru przesyłki
	if (isset($_POST['shipping'])) {
		$_SESSION['shipping'] = $_POST['shipping'];
	}

	$result = getData();

	function calculateTotal()
	{
		$total = 0;
		$result = getData();
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			if (isset($_SESSION['cart'][$row['product_id']])) {
				$quantity = $_SESSION['cart'][$row['product_id']]['quantity'];
				$total += $row['price'] * $quantity;
			}
		}
		return $total;
	}

	function getShippingCost($shippingOption)
	{
		$shippingCosts = [
			'standard' => 5.00,
			'express' => 10.00,
			'overnight' => 20.00
		];
		return $shippingCosts[$shippingOption] ?? 0;
	}


	$totalPrice = calculateTotal();
	
	if(isset($_SESSION['shipping'])) 
		$totalWithShipping = $totalPrice + getShippingCost($_SESSION['shipping']);
	else 
		$totalWithShipping = $totalPrice + getShippingCost('standard');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/x-icon" href="./img/favicon-32x32.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"">
	<link href=" https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer">
	<link rel="stylesheet" href="./cart.css">
	<link rel="stylesheet" href="./style.css">
	<title>Shopping Cart</title>
</head>
<body>
	<div id="div">
		<header class="mb-4 bg-dark">
			<div class="p-4 text-center">
				<div class="container">
					<div class="row">
						<div class="col-md-4 d-flex justify-content-center justify-content-md-start justify-content-xl-start mb-3 mb-md-0">
							<a href="./index.php" class="ms-md-3">
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
									<span><i class="fa-solid fa-user">Sign in</i></span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>



		<main class="page">
			<section class="shopping-cart dark">
				<div class="container">
					<div class="block-heading">
						<h2>Shopping Cart</h2>
					</div>
					<div class="content">
						<div class="row">
							<div class="col-md-12 col-lg-8">
								<div class="items">
									<?php
										$result = getData();
										while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
											foreach ($_SESSION['cart'] as $product_id => $cartItem) {
												if ($product_id == $row['product_id']) {
													cart($row['name'], $row['price'], $row['photo'], $row['product_id']);
												}
											}
										}
									?>
								</div>
							</div>
							<div class="col-md-12 col-lg-4">
								<div class="summary">
									<h3>Summary</h3>
									<div class="summary-item"><span class="text">Subtotal</span><span class="price">$<?php echo number_format($totalPrice, 2); ?></span></div>
									<div class="summary-item"><span class="text">Shipping</span>
										<form method="post" action="">
											<select name="shipping" onchange="this.form.submit()">
												<option value="standard" <?php if (isset($_SESSION['shipping']) && $_SESSION['shipping'] == 'standard') echo 'selected'; ?>>Standard - $5.00</option>
												<option value="express" <?php if (isset($_SESSION['shipping']) && $_SESSION['shipping'] == 'express') echo 'selected'; ?>>Express - $10.00</option>
												<option value="overnight" <?php if (isset($_SESSION['shipping']) && $_SESSION['shipping'] == 'overnight') echo 'selected'; ?>>Overnight - $20.00</option>
											</select>
										</form>
									</div>
									<div class="summary-item"><span class="text">Total</span><span class="price">$<?php echo number_format($totalWithShipping, 2); ?></span></div>
									<a href="finalization.php?total_price=<?php echo $totalWithShipping ?>&shipping=<?php echo isset($_SESSION['shipping']) ? $_SESSION['shipping'] : 'standard'; ?>" class="btn btn-warning btn-lg btn-block">Checkout</a>
								</div>
							</div>
						</div>
					</div>
			</section>
		</main>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
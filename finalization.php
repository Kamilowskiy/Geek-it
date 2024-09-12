<?php
session_start();

function getDbConnection()
{
    $host = 'sql113.lh.pl';
    $db = 'serwer244499_geek';
    $user = 'serwer244499';
    $pass = 'Kamil123#$#';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

// Pobranie totalPrice i shipping method z parametrów URL
$totalPrice = isset($_GET['total_price']) ? $_GET['total_price'] : 0;
$shippingMethod = isset($_GET['shipping']) ? $_GET['shipping'] : 'standard';


if (isset($_POST['submit_order'])) {
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
    $country = $_POST['country'];

    // wstawienie zamówienia do bazy danych
    try {
        $conn = getDbConnection();
        $query = "INSERT INTO orders (total_price, delivery_type, adress, zipcode, city, country) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$totalPrice, $shippingMethod, $address, $zipcode, $city, $country]);
        echo "Order submitted successfully";
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalization</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }

        .form-group label {
            color: #495057;
            font-weight: 500;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #80bdff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .readonly-input {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        .readonly-input::placeholder {
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Finalization</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label for="zipcode">Zip Code</label>
                <input type="text" class="form-control" id="zipcode" name="zipcode" required>
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" class="form-control" id="country" name="country" required>
            </div>
            <div class="form-group">
                <label for="shipping_method">Shipping Method</label>
                <input type="text" class="form-control" id="shipping_method" name="shipping_method" value="<?php echo ucfirst($shippingMethod); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="total_price">Total Price</label>
                <input type="text" class="form-control" id="total_price" name="total_price" value="$<?php echo number_format($totalPrice, 2); ?>" readonly>
            </div>
            <button type="submit" class="btn btn-primary" name="submit_order">Place Order</button>
        </form>
    </div>
</body>

</html>
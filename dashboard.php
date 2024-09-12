<?php
    session_start();

    $dsn = 'mysql:host=sql113.lh.pl;dbname=serwer244499_geek;charset=utf8mb4';
    $username = 'serwer244499';
    $password = 'Kamil123#$#';

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add'])) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $photo = file_get_contents($_FILES['photo']['tmp_name']);

            $query = "INSERT INTO products (name, price, description, photo) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$name, $price, $description, $photo]);

            header("Location: dashboard.php");
            exit();
        }

        if (isset($_POST['update'])) {
            $product_id = $_POST['product_id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $photo = !empty($_FILES['photo']['tmp_name']) ? file_get_contents($_FILES['photo']['tmp_name']) : null;

            if ($photo) {
                $query = "UPDATE products SET name = ?, price = ?, description = ?, photo = ? WHERE product_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->execute([$name, $price, $description, $photo, $product_id]);
            } else {
                $query = "UPDATE products SET name = ?, price = ?, description = ? WHERE product_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->execute([$name, $price, $description, $product_id]);
            }

            header("Location: dashboard.php");
            exit();
        }

        if (isset($_POST['delete'])) {
            $product_id = $_POST['product_id'];

            $query = "DELETE FROM products WHERE product_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$product_id]);

            header("Location: dashboard.php");
            exit();
        }
    }

    $query = "SELECT * FROM products";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/dashboard.css">
</head>

<body class="bg-dark text-white">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">Manage Products</h1>

        <h2>Add Product</h2>
        <form action="dashboard.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input class="form-control" type="file" id="photo" name="photo" required>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Add Product</button>
        </form>

        <h2 class="mt-5">Products</h2>
        <table class="table table-bordered text-white">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                    <td><img src="data:image/jpeg;base64,<?php echo base64_encode($product['photo']); ?>" style="width: 100px;"></td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $product['product_id']; ?>">Edit</button>

                        <!-- Delete Button -->
                        <form action="dashboard.php" method="post" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>

                <div class="modal fade" id="editModal<?php echo $product['product_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-white">
                                <form action="dashboard.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="photo" class="form-label">Photo</label>
                                        <input class="form-control" type="file" id="photo" name="photo">
                                    </div>
                                    <button type="submit" name="update" class="btn btn-primary">Update Product</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

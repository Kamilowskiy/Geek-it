<?php
    $dsn = 'mysql:host=sql113.lh.pl;dbname=serwer244499_geek;charset=utf8mb4';
    $username = 'serwer244499';
    $password = 'Kamil123#$#';

    try {
        $conn = new PDO($dsn, $username, $password);
        // Ustawienie opcji PDO_ATTR_EMULATE_PREPARES na false, aby uniknąć emulacji prepare
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        // Ustawienie opcji PDO_ATTR_ERRMODE na ERRMODE_EXCEPTION, aby wyświetlić błędy jako wyjątki
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    if(isset($_GET['query'])) {
        $search = strtolower($_GET["query"]); // Konwersja wprowadzonego zapytania na małe litery

        $sql = "SELECT * FROM products WHERE LOWER(name) LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["%$search%"]);

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<li class='list-group-item'><a href='product.php?id=" . $row["product_id"] . "'>" . $row["name"] . " - Price: $" . $row["price"] . "</a></li>";
            }
        } 
        else {
            echo "<li class='list-group-item'>No products found</li>";
        }
    } 
    else {
        echo "<li class='list-group-item'>Please enter a search query</li>";
    }


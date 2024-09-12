<?php
function getData()
{
    try {
        $dsn = 'mysql:host=sql113.lh.pl;dbname=serwer244499_geek;charset=utf8mb4';
        $username = 'serwer244499';
        $password = 'Kamil123#$#';

        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM products";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    } 
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function display($name, $price, $photo, $product_id)
{
    $image = '<img style="object-fit: contain; height: 270px; width: 100%;" src="data:image/jpeg;base64,' . base64_encode($photo) . '"/>';

    $element = "
    
    <div class='col col-11 col-md-4 col-lg-3 col-xl-3'>
        <div class='product-grid'>
            <div class='product-image'>
                <a href='product.php?id=$product_id' class='image'>$image</a>
                <ul class='product-links'>
                    <form action='index.php' method='post'>
                        <button id='cart-add' class='fa fa-shopping-cart' type='submit' name='add'></button>	
                        <input type='hidden' name='product_id' value='$product_id'>
                </ul>
            </div>
            <div class='product-content'>
                <h3 class='title'><a href='product.php?id=$product_id'>$name</a></h3>
                <div class='price'>$price$</div>
            </div>
        </div>
    </div>
    
    </form>
    ";

    echo $element;
}

function cart($name, $price, $photo, $product_id)
{
    $image = '<img class="img-fluid mx-auto d-block image" src="data:image/jpeg;base64,' . base64_encode($photo) . '"/>';

    $element = "
      <div class='product'>
                <div class='row'>
                    <div class='col-md-3 photo'>
                       $image
                    </div>
                    <div class='col-md-8'>
                        <div class='info'>
                            <div class='row'>
                                <div class='col-md-5 product-name'>
                                    <div class='product-name'>
                                        <a href='product.php?id=$product_id' id='description'>$name</a>
                                        <div class='product-info'>
                                             <form action='cart.php?action=remove&id=$product_id' method='post'>
                                                <button class='remove' type='submit' name='remove'></button>	
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-4 quantity'>
                                <div class='input-group'>
                                <form action='cart.php?id=$product_id' method='post'>
                                <label for='quantity'>Quantity:</label>
                                    <input id='quantity' type='number' value='{$_SESSION['cart'][$product_id]['quantity']}' class='form-control quantity-input' name='quantity' readonly>
                                    <div class='input-group-append'>
                                        <button type='submit' name='add' class='btn btn-outline-secondary'>+</button>
                                        <button type='submit' name='subtract' class='btn btn-outline-secondary'>-</button>
                                    </div>
                                </form>
                            </div>
                                </div>
                                <div class='col-md-3 price2'>
                                    <span>$$price</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";

    echo $element;
}

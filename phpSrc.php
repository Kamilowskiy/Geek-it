<?php
    function getData(){
        $connect = new mysqli('sql113.lh.pl', 'serwer244499', 'Kamil123#$#', 'serwer244499_geek');
        if ($connect->connect_error)
            echo "Error" . $connect;

        $sql = "SELECT * FROM products";
        $result = mysqli_query($connect, $sql);
        
        if (mysqli_num_rows($result) > 0)
            return $result;
    }

    function display($name, $price, $photo){
        $image = '<img style="object-fit: contain; height: 270px; width: 100%;" src="data:image/jpeg;base64,' . base64_encode($photo) . '"/>';
        
        $element = "
            <div class='col col-11 col-md-4 col-lg-3 col-xl-3'>
                <div class='product-grid'>
                    <div class='product-image'>
                        <a href='#' class='image'>$image</a>
                        <ul class='product-links'>
                            <li><a href='#'><i class='far fa-heart'></i></a></li>
                            <li><a href='#'><i class='fa fa-random'></i></a></li>
                            <li><a href='#'><i class='fa fa-eye'></i></a></li>
                            <li><a href='#'><i class='fa fa-shopping-cart'></i></a></li>
                        </ul>
                    </div>
                    <div class='product-content'>
                        <h3 class='title'><a href='#'>$name</a></h3>
                        <div class='price'>$price$</div>
                    </div>
                </div>
            </div>";

        echo $element;
    }
?>
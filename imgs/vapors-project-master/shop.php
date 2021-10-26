<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>

<body>
    <?php
    session_start();


    $conn = new mysqli("localhost", "f32ee", "f32ee", "f32ee");

    if ($conn->connect_error) {
    
        exit();
    }

    include './php/navbar.php';
    ?>
    <div class="container">
        <div class="row">
            <div class="three column">
                <?php include './php/filter.php' ?>
            </div>
            <div class="nine column u-p-zero">
                <div class="row">
                    <div class="twelve column">
                        <div class="search-result">
                            <div class="search-result__info">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $query = "SELECT p.id, p.name, p.price, p.discount FROM products AS p, inventory AS i WHERE p.id=i.productsID";

                foreach ($_GET as $category_name => $category_value_arr) {
                    if ($category_name != 'tag' && $category_name != 'price--min' && $category_name != 'price--max') {
                        $query = $query . ' AND (';
                        $first_item = true;
                        foreach ($category_value_arr as $category_value) {
                            if ($first_item) {
                                $query = $query . $category_name . '="' . $category_value . '"';
                                $first_item = false;
                            } else {
                                $query = $query . ' OR ' . $category_name . '="' . $category_value . '"';
                            }
                        }
                        $query = $query . ')';
                    }
                }
                $query = $query . ' GROUP BY p.id;';
                //echo $query;
                $result = $conn->query($query);

                if ($result) {
                    $num_rows = $result->num_rows;
                    if ($num_rows > 0) {
                        echo '<div class="row">';
                        $section_id = "collection--search";
                        for ($counter = 0; $counter < $num_rows; $counter++) {
                            $row = $result->fetch_assoc();
                            $product_id = $row["id"];
                            $product_name = $row["name"];
                            $product_price = $row["price"];
                            $product_discount = $row["discount"];
                            echo '<div class="four column">';
                            include './php/product.php';
                            echo '</div>';
                        }
                        echo '</div>';
                    } else { //No products correspond to search result

                    }
                } else {
                    //Unable to query database for search results
                    exit();
                }

                ?>
                <div class="row">
                    <div class="twelve column">
                        <div class="pagenumber shop__pagenumber">
                            <button>
                                <<</button> <button class="u-is-active">1
                            </button>
                            <button>>></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include './php/footer.php' ?>
    <script type="text/javascript" src='./js/script.js'></script>
</body>

</html>
<html xmlns="http://www.w3.org/1999/xhtml">

<?php include "includes/conn.php"; ?>
<?php include "includes/function.php"; ?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="noarchive">
    <link rel="stylesheet" href="css/css.css" />
    <title>Home</title>
</head>

<body>
    <?php include "includes/header.php"; ?>

    <div id="main" class="w_920 m_auto clear">

        <div id="products">

            <div class="search">
                <form method="get">
                    <input type="text" name="search" class="input"><button class="btn btn_primary">Search</button>
                </form>
            </div>

            <div class="products m_top_30">
                <?php
                if ($_GET['search']) {
                    $where = " and p.title like '%{$_GET['search']}%'";
                }
                $query = "select p.*,b.title as brandName from product p left join brand b on b.id = p.band_id where p.id > 0 {$where} order by p.id desc";
                //echo $query;
                $result = $conn->query($query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $imgs = json_decode($row['image']);
                ?>
                    <div class="item f_left t_center">
                        <div class="box">

                            <a href="detail.php?id=<?php echo $row['id'] ?>" />
                            <img src="imgs/product_4 1.png" />
                            </a>
                            <p class="pinpai"><?php echo $row['brandName'] ?></p>
                            <p><strong><?php echo $row['title'] ?></strong></p>
                            <p class="price"><strong>$<?php echo $row['price'] ?></strong></p>
                            <button class="btn_primary m_auto">Add To Cart</button>
                        </div>
                    </div>
                <?php } ?>


                <div class="clear"></div>
            </div>

            <div class="clear"></div>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>

</body>

</html>
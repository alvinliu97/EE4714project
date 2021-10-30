
<?php include "includes/conn.php"; ?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="noarchive">
    <link rel="stylesheet" href="css/css.css" />
    <title>Home</title>
</head>

<body>

    <?php include "includes/header.php"; ?>
    <?php
    $query = "select p.*,b.title as brandName from product p left join brand b on b.id = p.band_id where p.id = {$_GET['id']}";
    $result = $conn->query($query);
    $deatil = $result->fetch_assoc();
    $thumb = json_decode($deatil['image']);

    ?>
    <div id="main" class="w_920 m_auto clear">

        <div id="detail">
            <div class="bread">
                Home > Sensors > Button Acuator for Servo...
            </div>
            <div class="thumb border">

                <div class="album">
                    
                    <div class="show">
                        <img id="maxThumb" src="imgs/<?php echo $thumb[0]; ?>" />
                    </div>
                    <hr>
                    <div class="min">
                        <?php foreach ($thumb as $vo) { ?>
                            <img onmouseover="setMaxThumb('imgs/<?php echo $vo; ?>')" class="miniPic" src="imgs/<?php echo $vo; ?>" />
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="buy border">
                <div class="info">
                    <form method="get" action="addcart.php">
                        <h1 style="color:#284561;font-family:system-ui;"><?php echo $deatil['brandName']; ?></h1>
                        <h3><?php echo $deatil['title']; ?></h3>
                        <hr />
                        <h2>Description</h2>
                    <p>
                        <?php echo $deatil['descption']; ?>
                    </p>
                        <h2><strong>Price:</strong> $<?php echo $deatil['price']; ?> </h2>
                        <h2><strong>Stock:</strong> <?php echo $deatil['stock']; ?> <input type="hidden" class="stock" value="<?php echo $deatil['stock']; ?>" /><span id="stockTip" style="color:red;">Out of Stock</span></h2>
                        <h2>Quantity:<input type="number" value=1 min=1 max="<?php echo $deatil['stock']; ?>" class="num" name="num" onchange="checkStock()"></h2>
                        
                        <div class="clear"></div>
                        <input type="hidden" name="id" value="<?php echo $deatil['id']; ?>" />
                        <button style=" margin-top: -2%;" class="submit_order btn btn_primary w_100">Add to cart</button>
                    </form>
                </div>
            </div>
            <div class="clear"></div>

            <script>
                function setMaxThumb(thumb) {
                    document.getElementById("maxThumb").setAttribute('src', thumb);
                }


                function checkStock() {
                    var stock = document.getElementsByClassName('stock')[0].value;
                    var num = document.getElementsByClassName('num')[0].value;
                    if (stock * 1 < num * 1) {
                        document.getElementById("stockTip").style.display = ""
                        document.getElementsByClassName('submit_order')[0].disabled = true
                        document.getElementsByClassName("submit_order")[0].classList.remove("btn_primary");
                    } else {
                        document.getElementById("stockTip").style.display = "none"
                        document.getElementsByClassName('submit_order')[0].disabled = false
                        document.getElementsByClassName("submit_order")[0].classList.add("btn_primary");
                    }
                }

                checkStock();
            </script>

            <div class="products m_top_30">
                <h3 class="color_parimary">You May Also Like</h3>


                <?php
                $query = 'select p.*,b.title as brandName from product p left join brand b on b.id = p.band_id order by p.id desc  limit 4';
                //echo $query;
                $result = $conn->query($query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $imgs = json_decode($row['image']);
                ?>
                    <div class="item f_left t_center">
                        <div class="box">

                            <a href="detail.php?id=<?php echo $row['id'] ?>" />
                            <img src="imgs/<?php echo $imgs[0] ?>" />
                            </a>
                            <p class="pinpai"><?php echo $row['brandName'] ?></p>
                            <p><strong><?php echo $row['title'] ?></strong></p>
                            <p class="price"><strong>$<?php echo $row['price'] ?></strong></p>
                            <form method="get" action="addcart.php">
                                <input type="hidden" value="s" name="size" />
                                <input type="hidden" value="1" name="num" />
                                <input type="hidden" value="<?php echo $row['id'] ?>" name="id" />
                                <button class="btn_primary m_auto"<?php if ($row['stock'] == '0'){ ?> disabled <?php   } ?>>Add To Cart</button>
                            </form>
                        </div>
                    </div>
                <?php } ?>


                <div class="clear"></div>
            </div>

        </div>
    </div>
    <script>
        function setSize(s) {
            document.getElementsByClassName('size')[0].value = s;

        }
    </script>
    <?php include "includes/footer.php"; ?>
</body>

</html>
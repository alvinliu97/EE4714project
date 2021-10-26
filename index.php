<html xmlns="http://www.w3.org/1999/xhtml">
<?php include "includes/conn.php"; ?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="noarchive">
    <link rel="stylesheet" href="css/css.css" />
    <title>Home</title>
</head>

<body>
    <?php include "includes/header.php"; ?>

    <div id="main" class="w_920 m_auto clear">
        <div class="slider m_top_30">
            <img src="imgs/slider.png" />
        </div>
        <div class="cates m_top_30">
            <h3 class="color_parimary">
                BROWSE ALL CATEGORIES
            </h3>

            <?php
            $query = 'select * from cate order by id desc';
            //echo $query;
            $result = $conn->query($query);
         
            while ($rows = mysqli_fetch_assoc($result)) {
                
                ?>
               
                <div class="item f_left t_center">
                    <div class="icon m_auto">
                        <img src="imgs/<?php echo $rows['icon']; ?>" />
                    </div>
                    <p><strong><?php echo $rows['title']; ?></strong></p>
                </div>

            
                <?php
            } ?>

            <div class="clear"></div>
        </div>

        <div class="products m_top_30">
            <h3 class="color_parimary">BEST SELLERS</h3>
            <?php
            $query = 'select p.*,b.title as brandName from product p left join brand b on b.id = p.band_id order by p.id desc limit 4';
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
                            <button class="btn_primary m_auto">Add To Cart</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <div class="clear"></div>
        </div>
        <div class="faq m_top_30">
            <h3 class="color_parimary">FAQ</h3>
            <table class="table">
                <tr class="title">
                    <td colspan="2">Orders & Delivery</td>
                    <td align="right"><img src="imgs/up.png" </td>
                </tr>
                <tr>
                    <td colspan="3">What are the delivery options and when can I receive my order?</td>
                </tr>
                <tr>
                    <td>Delivery Type</td>
                    <td>Fee (SGD)</td>
                    <td>Timeframe (Business Days)</td>
                </tr>

                <tr>
                    <td>Standard</td>
                    <td>Free for Orders $20 and above</td>
                    <td>3-5</td>
                </tr>

                <tr>
                    <td>Express</td>
                    <td>$5</td>
                    <td>1-2*</td>
                </tr>

                <tr>
                    <td>POPStation</td>
                    <td>Free</td>
                    <td>3-5</td>
                </tr>

            </table>

            <table class="table">
                <tr class="title">
                    <td colspan="2">Returns & Exchanges</td>
                    <td align="right"><img src="imgs/down.png" </td>
                </tr>
            </table>

            <table class="table">
                <tr class="title">
                    <td colspan="2">Payment, Store Credit, Discount</td>
                    <td align="right"><img src="imgs/down.png" </td>
                </tr>
            </table>
            <div class="clear"></div>
        </div>


    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>
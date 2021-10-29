

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="noarchive">
    <link rel="stylesheet" href="css/css.css" />
    <title>Order Info</title>
    <?php include "includes/conn.php"; ?>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php
    $query = "select * from orders where id = {$_GET['id']}";
    $result = $conn->query($query);
    $deatil = $result->fetch_assoc();
    $products = json_decode($deatil['product'], true);

    ?>
    <div id="main" class="w_920 m_auto clear">

        <div id="payment">
           

            <div class="tip">
                <h1>ORDER CONFIRMATION</h1>
                <p><?php echo $deatil['s_firstname']; ?> <?php echo $deatil['s_lastname']; ?>, thank you for your order!<br />
                    We’ve received your order and will contact you as soon as your package is shipped. Meanwhile, you can find your purchase information below.</p>
           
            <h1 class="t_center">Order Summary</h1>

            <p class="t_center"><?php echo date("M-15, Y", strtotime($deatil['create_at'])); ?></p>

            <table border="1" cellspacing="0" class="w_100 t_center">
                <tr style="background: #003554; color:#fff">
                    <td>No.</td>
                    <td>Description</td>
                    <td>Unit Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>

                <?php
                $count = 0;
                foreach ($products as $vo) {
                    $query = "select p.*,b.title as brandName from product p left join brand b on b.id = p.band_id where p.id = {$vo['id']}";
                    $result = $conn->query($query);
                    $deatil = $result->fetch_assoc();
                    $thumb = json_decode($deatil['image']);
                    $count = $count + $vo['num'] * $deatil['price'];
                ?>
                    <tr>
                        <td><?php echo $vo['id']; ?></td>
                        <td><?php echo $deatil['title']; ?></td>
                        <td><?php echo $deatil['price']; ?></td>
                        <td><?php echo $vo['num']; ?></td>
                        <td><?php echo $deatil['price'] * $vo['num']; ?> </td>
                    </tr>
                <?php } ?>

            </table>
            <br />
            <h1 class="t_right"><strong>Total:</strong><?php echo $count ?></h1>
            <br />
            <hr />
            <div>
                <h1 class="t_center">MAKELECTRONIC</h1>
                <h3 class="t_center">SINGAPORE</h3>
            </div>
            <div class="clear"></div>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>

</body>

</html>


<?php include "includes/conn.php"; ?>
<?php include "includes/function.php"; ?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="robots" content="noarchive">
  <link rel="stylesheet" href="css/css.css" />
  <title>Poducts</title>
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
          $where .= " and p.title like '%{$_GET['search']}%'";
        }
        if ($_GET['catid']) {
          $where .= " and p.category_id = '{$_GET['catid']}'";
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

      <div class="clear"></div>
    </div>
  </div>

  <?php include "includes/footer.php"; ?>

</body>

</html>
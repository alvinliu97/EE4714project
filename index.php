
<?php include "includes/conn.php"; ?>
<?php include "includes/function.php"; ?>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="robots" content="noarchive">
  <link rel="stylesheet" href="css/css.css" />
  <title>Makelectronic</title>
  <script src="js/slide.js" type="text/javascript"></script>
</head>

<body>
  <?php include "includes/header.php"; ?>

  <div id="main" class="w_1280 m_auto clear">
    <!-- Start of Image Carousel Section -->
    <section id="image_carousel">
      <div class="slider m_top_30">
        <div class="banner" id="banner">
          <ul id="b_pic">
            <li style="display: block;"><img src="imgs/slider.png" alt=""></li>
            <li><img src="imgs/slider2.png" alt=""></li>
            <li><img src="imgs/slider3.png" alt=""></li>
          </ul>
          <ul id="b_an">
            <li></li>
            <li></li>
            <li></li>
          </ul>
        </div>
      </div>
    </section>
    <!-- End of Image Carousel Section -->

    <!-- Start of Categories Section -->
      <section id="categories">
        <div class="section_header">
          <h2 class="section_title">
            Browse All Categories
          </h2>
        </div>
        <div class="category">
          <?php
          $query = 'select * from cate order by id desc limit 5;';
          //echo $query;
          $result = $conn->query($query);
          while ($row = mysqli_fetch_assoc($result)) {
          ?>
            <a href="products.php?catid=<?php echo $row['id']; ?>" class="category_item">
              <div class="category_item_image_wrapper">
                <div class="aspect_ratio">
                  <img src="imgs/<?php echo $row['icon']; ?>" />
                </div>
              </div>
              <span class="category_item_title">
                <?php echo $row['title']; ?>
              </span>
            </a>
          <?php
          }
          ?>
          <div class="clear"></div>
        </div>
      </section>
    <!-- End of Categories Section -->

    <!-- Start of New products Section -->
      <section id="new_products">
        <div class="section_header">
          <h2 class="section_title">
            New Products
          </h2>
        </div>
        <div class="product_list">
        <?php
          $query = 'select p.*,b.title as brandName from product p left join brand b on b.id = p.band_id order by create_at desc limit 5';
          //echo $query;
          $result = $conn->query($query);
          while ($row = mysqli_fetch_assoc($result)) {
            $imgs = json_decode($row['image']);
          ?>
            <div class="product_item">
              <div class="product_image_wrapper">
                <div class="aspect_ratio">
                  <a href="detail.php?id=<?php echo $row['id'] ?>">
                    <img src="imgs/<?php echo $imgs[0] ?>" />
                  </a>
                </div>
              </div>
              <div class="product_item_info">
                <div class="product_item_info_inner">
                  <a href="detail.php?id=<?php echo $row['id'] ?>" class="product_item_brand color_primary">
                    <?php echo $row['brandName'] ?>
                  </a>
                  <a href="detail.php?id=<?php echo $row['id'] ?>" class="product_item_title text-strong color_primary">
                    <?php echo $row['title'] ?>
                  </a>
                  <div class="product_item_price">
                    <span class="price color_secondary text-strong">$<?php echo $row['price'] ?></span>
                  </div>
                </div>
                <form method="get" action="addcart.php">
                  <input type="hidden" value="s" name="size" />
                  <input type="hidden" value="1" name="num" />
                  <input type="hidden" value="<?php echo $row['id'] ?>" name="id" />
                  <button class="text-strong"<?php if ($row['stock'] == '0'){ ?> disabled <?php } ?> > <?php if ($row['stock'] == '0') { ?>Out of Stock<?php } else { ?>Add To Cart<?php } ?></button>
                </form>
              </div>
            </div>
          <?php } ?>
          <div class="clear"></div>
        </div>
      </section>
    <!-- End of New products Section -->
    
    <!-- Start of FAQ Section -->
      <section id="faq">
        <div class="section_header">
          <h2 class="section_title">
            Frequently Asked Questions (FAQ)
          </h2>
        </div>
        <div class="mx_auto">
          <button class="accordion">Orders & Delivery</button>
          <div class="panel">
            <p>All local orders in Singapore are shipped via our preferred courier partners, depending on the selected delivery method. After processing and leaving our warehouse, orders usually take between 1 to 3 working days (excluding weekends and public holidays) to arrive at their destination. However, it may take longer from time to time due to reasons such as festive season.</p>
          </div>

          <button class="accordion">Returns & Exchanges </button>
          <div class="panel">
            <p>We offer exchanges or refunds for defective products within 30 days from the date of purchase.

To be eligible for a return, your item must be in the same condition that you received it. You will also be required to return the item along with its original packaging. Flammable goods, such as batteries, are exempt from being returned.

To request for a refund or exchange, please send us an email at contact@Makelectronic.sg with a copy of your receipt or proof of purchase, and provide details on the suspected defect.</p>
          </div>

          <button class="accordion">Payment, Store Credit, Discount</button>
          <div class="panel">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div>
        </div>
      </section>
    <!-- End of FAQ Section -->
  </div>
  <?php include "includes/footer.php"; ?>
</body>

</html>
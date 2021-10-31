
<?php include "includes/conn.php"; ?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="robots" content="noarchive">
  <link rel="stylesheet" href="css/css.css" />
  <title>Orders</title>
</head>

<body>
  <?php include "includes/header.php"; ?>

  <div id="main" class="w_920 m_auto clear">
    <div class="bread">
      Home > My Account > My Orders
    </div>
    <div id="order">
      <div class="left">
        <div class="top border">
          <div class="logo">
            <div class="icon border">
              <?php echo substr($_COOKIE['firstName'], 0, 1) ?>
            </div>
            <p><strong>&nbsp&nbsp<?php echo   strtoupper($_COOKIE['firstName']) . ' ' . strtoupper($_COOKIE['lastName'])   ?></strong></p>
          </div>
          <div class="clear"></div><br />

          <?php

          $query = "select * from user where id = {$_COOKIE['uid']}";
          $result = $conn->query($query);
          $user = mysqli_fetch_assoc($result);
          ?>
          <p class="t_center">Member since <?php echo date('Y', strtotime($user['create_at'])) ?></p>
        </div>

        <div class="bottom border">
          <h3>My Orders</h3>
          <div class="clear"></div>
          <br />
          <P class="t_center"><a href="logout.php">Logout</a></P>
        </div>
      </div>

      <div class="right border">
        <h3>Orders</h3>

        <table>
          <tr>
            <td>ID</td>
            <td>Date</td>
            <td>Payment</td>
            <td>Receipt</td>
          </tr>

          <?php
          $query = "select * from orders where uid = {$_COOKIE['uid']} order by id desc";
          $result = $conn->query($query);
          while ($row = mysqli_fetch_assoc($result)) {

          ?>
            <tr>
              <td>#<?php echo $row['id'] ?></td>
              <td><?php echo $row['create_at'] ?></td>
              <td><button class="btn btn_success">Done</button></td>
              <td><a href="orderinfo.php?id=<?php echo $row['id'] ?>">Receipt</a></td>
            </tr>
          <?php } ?>

        </table>
      </div>

      <div class="clear"></div>
    </div>
  </div>

  <?php include "includes/footer.php"; ?>

</body>

</html>
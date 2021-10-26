<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>

<body>
	<?php
	session_start();
	//Connect to database
	$conn = new mysqli("localhost", "f32ee", "f32ee", "f32ee");

	if ($conn->connect_error) {
		//Fallback if unable to connect to database
		include_once('./php/error.php');
		exit();
	}

	include './php/navbar.php';
	?>
	<div class="container">
		<div class="row">
			<div class="two column"></div>
			<div class="eight column">
				<section class="support">
					<section class="support__section" id="shipping-delivery">
						<h3 class="header"><a href="#shipping-delivery" class="button--text">Shipping and Delivery</a></h3>
						<br>
						<table class="u-fill">
							<tr class="table__row">
								<th>
									Type
								</th>
								<th>
									Cost
								</th>
								<th>
									<span class="u-no-wrap">Shipping Time</span>
								</th>
								<th>
									<span class="u-no-wrap">Availability</span>
								</th>
							</tr>
							<tr class="table__row">
								<td>
									Standard
								</td>
								<td>
									$6.00
								</td>
								<td>
									3 - 5 working days
								</td>
								<td>
									<span class="u-no-wrap">Mondays - Fridays</span><br>
									<span class="u-no-wrap">Not available on Public Holidays</span>
								</td>
							</tr>
						</table>
					</section>
					<section class="support__section" id="return-policy">
						<h3 class="header"><a href="#return-policy" class="button--text">Return Policy</a></h3>
						<p>
							You can, within 14 days of the order being received, return any goods in saleable condition.
						</p>
						<p>
							To process your return, please contact our customer center at 8888 8888 or f32ee@localhost.
						</p>
					</section>
					<section class="support__section" id="help">
						<h3 class="header"><a href="#help" class="button--text">Contact Us</a></h3>
						<p>
							Feel free to <a href="./contact.php">contact us</a> and let us know how we could help you! We will reply to your query within 1 working day.
						</p>
					</section>
				</section>
			</div>
			<div class="two column"></div>
		</div>
	</div>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/script.js'></script>
</body>

</html>
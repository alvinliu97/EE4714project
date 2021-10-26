<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>

<body>
	<?php
	session_start();

	//Connect to database
	$conn = new mysqli("localhost", "f32ee", "f32ee", "f32ee");

	include './php/navbar.php';

	if ($conn->connect_error) {
		include_once('./php/error.php');
		exit();
	}

	if (isset($_POST["send"])) {
		$email = $_POST["email"];
		$msg = $_POST["message"];
		$to      = 'f32ee@localhost';
		mail($to, "Enquires from Customer: " . $email, $msg);
	}

	?>
	<section class="contact">
		<div class="container">
			<div class="row">
				<div class="three column"></div>
				<div class="six column">
					<form onsubmit="return validateEmail();" method="post">
						<input type="hidden" name="send">
						<h2 class="header u-m-large--bottom">Contact Us</h2>
						<div class="u-flex">
							<div class="u-m-medium--bottom">
								<label for="email" class="label--required label--top">
									Email
								</label>
								<input type="text" name="email" id="email" onchange="validateEmail()" class="input--text u-fill" placeholder="name@email.com" required>
							</div>
							<div class="u-m-large--bottom">
								<label for="message" class="label--required label--top">
									Message
								</label>
								<textarea name="message" id="message" class="input--text u-fill" rows="5" placeholder="Enter your message."></textarea>
							</div>
						</div>
						<div>
							<button type="submit" class="button button--primary button--large">
								Submit
							</button>
						</div>
					</form>
				</div>
				<div class="three column"></div>
			</div>
		</div>
	</section>
	<?php include './php/footer.php' ?>
	<script type="text/javascript" src='./js/script.js'></script>
</body>

</html>
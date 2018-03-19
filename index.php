<?php require 'header.php'; ?>
	<body>
		<h1 class="text-center">Sukishi Checkpoint Online</h1>
		<br>
		<form action="checkpoint.php" name="authen_form" method="post">
		<input type="password" name="authen_password">
		<button type="submit" name="authen_submit">Authen</button>
		</form>
		<br>
	</body>
<?php require 'footer.php'; ?>
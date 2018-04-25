<?php require 'header.php'; ?>
	<body>
		<h1 class="text-center">Sukishi Checkpoint Online</h1>
		<br>
		<form action="checkpoint.php" name="authen_form" method="post">
		<h2>User</h2>
		<input type="text" name="authen_user" placeholder="user..." required>
		<h2>Password</h2>
		<input type="password" name="authen_password" placeholder="pass..." required>
		<br>
		<br>
		<button type="submit" name="authen_submit">login</button>
		</form>
		<br>
	</body>
<?php require 'footer.php'; ?>
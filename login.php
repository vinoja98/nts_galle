<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>	
<?php 

	// check for form submission
	if (isset($_POST['submit'])) {

		$errors = array();

		// check if the username and password has been entered
		if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1 ) {
			$errors[] = 'Username is Missing / Invalid';
		}

		if (!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1 ) {
			$errors[] = 'Password is Missing / Invalid';
		}

		// check if there are any errors in the form
		if (empty($errors)) {
			// save username and password into variables
			$email 		= mysqli_real_escape_string($connection, $_POST['email']);
			$password 	= mysqli_real_escape_string($connection, $_POST['password']);
			$hashed_password = sha1($password);

			// prepare database query
			$query = "SELECT * FROM user 
						WHERE email = '{$email}' 
						AND password = '{$hashed_password}' 
						LIMIT 1";

			$result_set = mysqli_query($connection, $query);

			if ($result_set) {
				// query succesfful

				if (mysqli_num_rows($result_set) == 1) {
					// valid user found
					$user = mysqli_fetch_assoc($result_set);
					$_SESSION['user_id'] = $user['id'];
					$_SESSION['first_name'] = $user['first_name'];
					$_SESSION['admin'] = $user['admin'];
					// redirect to users.php
					header('Location: users.php');
				} else {
					// user name and password invalid
					$errors[] = 'Invalid Username / Password';
				}
			} else {
				$errors[] = 'Database query failed';
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/log.css">
</head>
<body background="img/green.jpg">
	<div class="icon"><img src="img/home.ico" width="22" height="22"></div>
	<div class="top"><a href="index.php">Home</a></div>
	<div class="mid clearfix">
		<h3>User Login</h3>
		<div class="mid-right clearfix">
			<form action="login.php" method="post">
			<?php 
					if (isset($errors) && !empty($errors)) {
						echo '<p class="error">Invalid Username / Password</p>';
					}
			?>	
			<input type="text" name="email" id="" placeholder="Username">
			<br/>
			<br/>
			<input type="password" name="password" id="" placeholder="Password"><br/><br/>
			<button type="submit" name="submit">Log In</button>
		</div>
	</div>
</body>
</html>

<?php mysqli_close($connection); ?>
<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php 
	if (!isset($_SESSION['user_id'])){
			header('Location: login.php');
		}
?>
<!DOCTYPE html>
<html>
<head>
	<title>User Page</title>
	<link rel="stylesheet" type="text/css" href="css/user.css">
</head>
<body>
	<header>
		<div class="logger">Welcome <?php echo $_SESSION['first_name'] ?>!&nbsp <a href="logout.php">Log Out</a> </div>
	</header>
</body>
</html>
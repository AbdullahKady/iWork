<?php 
	session_start();
	unset($_SESSION['logged_in_user']);
	print_r($_SESSION);
	header("Location: index.php");
	die();
?>
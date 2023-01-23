<?php

	session_start();

	if (!isset($_SESSION['udanarejestracja']))
	{
		header('Location:../index.php');
		exit();
	}
	else
	{
		unset($_SESSION['udanarejestracja']);
	}

	if(isset($_SESSION['fr_name'])) unset($_SESSION['fr_name']);
	if(isset($_SESSION['fr_surname'])) unset($_SESSION['fr_surname']);
	if(isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if(isset($_SESSION['fr_password'])) unset($_SESSION['fr_password']);
	if(isset($_SESSION['fr_phone'])) unset($_SESSION['fr_phone']);
	if(isset($_SESSION['fr_agree'])) unset($_SESSION['fr_agree']);


	if(isset($_SESSION['e_name'])) unset($_SESSION['e_name']);
	if(isset($_SESSION['e_surname'])) unset($_SESSION['e_surname']);
	if(isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if(isset($_SESSION['e_password'])) unset($_SESSION['e_password']);
	if(isset($_SESSION['e_phone'])) unset($_SESSION['e_phone']);
	if(isset($_SESSION['e_agree'])) unset($_SESSION['e_agree']);

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>My Login Page</title>
</head>

	Dziękujemy za rejestrację w serwisie! Możesz już zalogowac się na swoje konto 
	<a href="index2.php"> zaloguj się </a>


</body>
</html>

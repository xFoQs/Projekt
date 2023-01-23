<?php


session_start();

if(isset($_POST['email']))
{
	//Udana walidacja
	$wszystko_OK = true;

	$name = $_POST['name'];

	//Sprawdzenie długości imienia

	if((strlen($name)<3) || (strlen($name)>20))
	{
		$wszystko_OK = false;
		$_SESSION['e_name'] = "Imię musi posiadać od 3 do 20 znaków!";
	}

	$email = $_POST['email'];
	$surname = $_POST['surname'];
	$phone = $_POST['phone'];
	$haslo = $_POST['password'];

	if((strlen($haslo)<8) || (strlen($haslo)>20))
	{
		$wszystko_OK = false;
		$_SESSION['e_haslo'] = "Hasło musi posiadac od 8 do 20 znaków";
	}

	$password_hash = password_hash($haslo, PASSWORD_DEFAULT);
	// echo $password_hash; exit();


	if(!isset($_POST['agree']))
	{
		$wszystko_OK = false;
		$_SESSION['e_agree'] = "Potwierdź akceptację regulaminu!";
	}

	$sekret = "6LcpeGEfAAAAAGENAKciMGR2RXi4nSiaW2P2JG8P";

	$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);

	$odpowiedz = json_decode($sprawdz);

	if ($odpowiedz -> success == false)
	{
		$wszystko_OK = false;
		$_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem!";
	}

	//Zapamiętaj wprowadzone dane
	$_SESSION['fr_name'] = $name;
	$_SESSION['fr_surname'] = $surname;
	$_SESSION['fr_email'] = $email;
	$_SESSION['fr_password'] = $haslo;
	$_SESSION['fr_phone'] = $phone;

	if(isset($_POST['agree'])) $_SESSION['fr_agree'] = true;
	

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);

	try
	{
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT id_czytelnik FROM czytelnicy WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}

				if($wszystko_OK == true)
				{
					//Hura, wszytskie testy zaliczone, rejestracja wykonana pomyślnie
					if ($polaczenie -> query("INSERT INTO czytelnicy VALUES (NULL,'$name','$surname','$email','$password_hash','$phone')"))
					{
						$_SESSION['udanarejestracja'] = true;
						header('Location:witamy.php');
					}
					else
					{
						throw new Exception($polaczenie -> error);
					}
				}

			 $polaczenie->close();

		    }

	}catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
		echo '<br/> Informacja developerska: '.$e;
	}

	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>My Login Page</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
	<script src="https://www.google.com/recaptcha/api.js"></script>

	<style>

	.error
	{
		color:red;
		margin-top: 10px;
		margin-bottom: 10px;
	}
	

	</style>


</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
					<a href="../index.php"><img src="https://media.istockphoto.com/vectors/book-library-icon-vector-id1271769852?k=20&m=1271769852&s=170667a&w=0&h=dg56yyBI-6A-gvCDQYGimf5T_IlwCrkSuog2lT2J62o=" alt="logo"></a>
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Register</h4>
							<form method="post" class="my-login-validation" novalidate="">
								<div class="form-group">
									<label for="name">Name</label>
									<input id="name" value="<?php

											if (isset($_SESSION['fr_name']))
											{
												echo $_SESSION['fr_name'];
												unset($_SESSION['fr_name']);
											}
										?>"
																	
									type="text" class="form-control" name="name" required autofocus >

									<?php

											if(isset($_SESSION['e_name']))
											{
												echo '<div class="error">'.$_SESSION['e_name'].'</div>';
												unset($_SESSION['e_name']);
											}

										?>

									<div class="invalid-feedback">
										What's your name?
									</div>
								</div>

								<div class="form-group">
									<label for="name">Surname</label>
									<input id="surname" type="text" class="form-control" name="surname" value="<?php

											if (isset($_SESSION['fr_surname']))
											{
												echo $_SESSION['fr_surname'];
												unset($_SESSION['fr_surname']);
											}
											?>"

									required autofocus>
									<div class="invalid-feedback">
										What's your surname?
									</div>
								</div>

								<div class="form-group">
									<label for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email"  value="<?php

										if (isset($_SESSION['fr_email']))
										{
											echo $_SESSION['fr_email'];
											unset($_SESSION['fr_email']);
										}
										?>"
									required>


									<?php

											if(isset($_SESSION['e_email']))
											{
												echo '<div class="error">'.$_SESSION['e_email'].'</div>';
												unset($_SESSION['e_email']);
											}

										?>

									<div class="invalid-feedback">
										Your email is invalid
									</div>
								</div>

								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" type="password" class="form-control" name="password"  value="<?php

											if (isset($_SESSION['fr_password']))
											{
												echo $_SESSION['fr_password'];
												unset($_SESSION['fr_password']);
											}
											?>"
									 required data-eye>

									<?php

											if(isset($_SESSION['e_haslo']))
											{
												echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
												unset($_SESSION['e_haslo']);
											}

										?>

									<div class="invalid-feedback">
										Password is required
									</div>
								</div>

								<!-- <div class="form-group">
									<label for="tel">Enter your phone number</label>
									<input id="tel" type="tel" class="form-control" name="phone" required data-eye pattern="+[0-9]{2} [0-9]{3}-[0-9]{3}-[0-9]{3}">
									<div class="invalid-feedback">
										Phone number is required
									</div>
								</div> -->

								<div class="form-group">
									<label for="form1">Phone number</label>
									<input type="text" id="form1" class="form-control" style="display: none;" name="phone"  value="<?php

											if (isset($_SESSION['fr_phone']))
											{
												echo $_SESSION['fr_phone'];
												unset($_SESSION['fr_phone']);
											}
											?>">
									<div class="invalid-feedback">
										Phone number is required
									</div>
									<input type="text" id="form2" class="form-control" value="<?php

										if (isset($_SESSION['fr_phone']))
										{
											echo $_SESSION['fr_phone'];
											unset($_SESSION['fr_phone']);
										}
										?>"
									 required>
									<div class="invalid-feedback">
										Phone number is required
									</div>

									
								</div>

									<div class="g-recaptcha" data-sitekey="6LcpeGEfAAAAAEAZDt61vQmIzuMG6RD2oV8Rx2T4" style="transform:scale(1.11);-webkit-transform:scale(1.11);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>

									<?php

											if(isset($_SESSION['e_bot']))
											{
												echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
												unset($_SESSION['e_bot']);
											}

										?>

							</div>

							


								<div class="form-group ml-4">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="agree" id="agree" class="custom-control-input" 
										<?php
												if (isset($_SESSION['fr_agree']))
												{
													echo "checked";
													unset($_SESSION['fr_agree']);
												}
										?>

										/>
										<label for="agree" class="custom-control-label" name="agree">I agree to the <a href="#">Terms and Conditions</a></label>



										<?php

											if(isset($_SESSION['e_agree']))
											{
												echo '<div class="error">'.$_SESSION['e_agree'].'</div>';
												unset($_SESSION['e_agree']);
											}

										?>

										
										<div class="invalid-feedback">
										You must agree with our Terms and Conditions
										</div>
									</div>
								</div>

								


								<div class="form-group m-1" >
									<button type="submit" class="btn btn-primary btn-block" >
										Register
									</button>

								</div>
								<div class="mt-4 text-center">
									Already have an account? <a href="index2.php">Login</a>
								</div>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/my-login.js"></script>

	<script>
		$("input[id='form2']").on("input", function () {
            $("input[id='form1']").val(destroyMask(this.value));
            this.value = createMask($("input[id='form1']").val());
        })

        function createMask(string) {
            console.log(string)
            return string.replace(/(\d{3})(\d{3})(\d{3})/, "$1-$2-$3");
        }

        function destroyMask(string) {
            console.log(string)
            return string.replace(/\D/g, '').substring(0, 9);
        }
	</script>




	
</body>
</html>
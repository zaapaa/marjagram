<!DOCTYPE html>
<?php 
session_start();
?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Marjagram</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet" type="text/css">
		<link href="tyyli.css" rel="stylesheet">
	</head>
	<body class="blue">
		<div id="wrapper">
			<header><h1 id="pagetitle">Luo käyttäjä</h1></header>
			<nav id="top">
				<ul>
					<li><a class="purple" id="menuButton" href="#">Menu &#9776;</a></li>
				</ul>
				<ul id="menu">
					<?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == "yes"){
						include 'includes/menu_Logged.php';
					}else {
						include 'includes/menu_notLogged.php';
					}?>
				</ul>
			</nav>
			<div id="content-wrapper" class="purple">
				<nav id="left">
					<ul>
                        <?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == "yes"){ ?>
						  <li><a class="accent button" href="includes/logout.php">Log Out</a></li>
                        <?php } ?>
						<li><a class="accent button" href="">Anna palautetta</a></li>
					</ul>
				</nav>
				<main class="highlight">
					<article>
						<h1>Kirjaudu sisään tai luo uusi käyttäjä!</h1>
                        <form action="includes/saveUser.php" method="post">
                            <fieldset>
                                <legend>Käyttäjätiedot:</legend>
                                Etunimi:<br>
                                <input type="text" name="givenFName" required><br>
                                Käyttäjänimi:<br>
                                <input type="text" name="givenUser" required><br>
                                Sähköposti:<br>
                                <input type="email" name="givenEmail" required><br>
                                Salasana:<br>
                                <input type="password" id="password" name="givenPw" required><br>
                                Salasana uudestaan:<br>
                                <input type="password" id="confirm_password" name="givenPwAgain" required><br>
                                <input type="submit" name="register" id="submit" value="Rekisteröidy">
                                <script>
                                var pw = document.querySelector('input[name="givenPw"]');
                                var pw2 = document.querySelector('input[name="givenPwAgain"]');
                                var fillPattern = function(){
                                	pw2.pattern = pw.value;
                                }

                                pw.addEventListener('keyup', fillPattern);
                                </script>
                            </fieldset>
                        </form>
                        <?php 
                        echo($_SESSION['message']."<br>"); ?>
					</article>
				</main>

			</div>
			<footer class="purple">
			<?php
			                if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == "yes"){ 
                	include 'includes/logoutbutton.php';
                	 }
                ?>
			&#169; Made by Marjatarha</footer>
		</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script>
		$(function(){
			$('#menuButton').click(function(evt){
				$('#menu').slideToggle(400);
			});
		});
	</script>
	</body>
</html>
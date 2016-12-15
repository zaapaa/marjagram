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
			<header><h1 id="pagetitle">Kirjaudu</h1></header>
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
                        <form action="includes/login.php" method="post">
                            <fieldset>
                                <legend>Käyttäjätiedot:</legend>
                                Käyttäjänimi:<br>
                                <input type="text" name="givenUser"><br>
                                Salasana:<br>
                                <input type="password" id="password" name="givenPw"><br>
                                <input type="submit" name="login" value="Kirjaudu sisään">
                            </fieldset>
                        </form>
                        <?php echo($_SESSION['message']."<br>"); ?>
					</article>
                    <h2><a class="purple" id="createButton" href="luo.php">Luo uusi käyttäjä</a></h2>
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
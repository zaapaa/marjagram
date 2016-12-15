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
			<header><h1 id="pagetitle">Selaa</h1></header>
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
						<h1>Selaa julkaistua mediaa.</h1>
						<form method="post">
						Hae:<input type="search" results=5 name="search" placeholder="hakusana"><input type="submit" name="submitsearch" value="Hae">
						</form>
						<?php
						$_SESSION['search'] = -1;
						if(isset($_POST['submitsearch'])){
							$_SESSION['search'] = $_POST['search'];
						}
						if($_SESSION['search'] == $_POST['search']){
							?>
							<script src="js/search.js"></script>
							<?php
						}
						?>
						<ul id = "SearchImg">
						</ul>

						<script src="js/mediakuvat.js"></script>						
						
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
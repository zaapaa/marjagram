<!DOCTYPE html>
<?php
session_start();
require_once 'config/config.php';
require_once 'functions/functions.php';
require_once 'includes/getUserInfo.php';
?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Oma profiili</title>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet" type="text/css">
		<link href="tyyli.css" rel="stylesheet">
	</head>
	<body class="blue">
		<div id="wrapper">
			<header><h1 id="pagetitle">Oma profiili</h1></header>
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
						<h1>Tässä näkyvät käyttäjätietosi:</h1>
                        <li>Käyttäjänimi: <?php echo $username; ?></li>
                        <li>Etunimi: <?php echo $fname; ?></li>
                        <li>Sukunimi: <?php echo $lname; ?></li>
                        <li>Sukupuoli: <?php echo $gender; ?></li>
                        <li>Syntymäpäivä: <?php echo $bdate; ?></li>
                        <li>Sähköposti: <?php echo $email; ?></li>
					</article>
					<button onclick="showUpdateForm()" id="updatebutton">päivitä</button>
					<article id="update"></article>
					
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
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		$(function(){
			$('#menuButton').click(function(evt){
				$('#menu').slideToggle(400);
			});
		});

		var button = document.querySelector("#updatebutton");
		var update = document.querySelector("#update");

		button.addEventListener('click', showUpdateForm);

		var showUpdateForm = function(){
			update.innerHTML = '<form action="includes/updateProfile.php" method="post">'+
			'Etunimi: <input type="text" name="newFName"><br>'+
			'Sukunimi: <input type="text" name="newLName"><br>'+
			'Sukupuoli: <select name="newGender">'+
			'	<option value=""></option>'+
			'	<option value="Mies">Mies</option>'+
			'	<option value="Nainen">Nainen</option>'+
			'	<option value="Apache">Apache-taisteluhelikopteri</option>'+
			'	<option value="Muu">Muu</option>'+
			'</select><br>'+
			'Syntymäpäivä: <input type="date" name="newBDate" id="bdate"><br>'+
			'Sähköposti: <input type="email" name="newEmail"><br>'+
			'<input type="submit" name="updateProfile" value="Päivitä tiedot"><br>'+
			'</form>';

			$( function() {
				  $( "#bdate" ).datepicker({
					  dateFormat: "yy-mm-dd"
				  });
			} );
			
		}

			
		
	</script>
	

	
	</body>
</html>
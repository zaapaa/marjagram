<!DOCTYPE html>
<?php
	session_start();
	require_once 'functions/functions.php';

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
			<header>
                <!--<?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == "yes"){ ?>
                    <h2><a class="purple" id="logOut" href="includes/logout.php">Log Out</a></h2>
                <?php } ?> -->
                <h1 id="pagetitle">Marjagram</h1>
            </header>
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
						<h1>Tervetuloa Marjagramiin!</h1>
						<ul>
                            <strong>Klikkaa yllä sijaitsevasta valikosta "Kirjaudu", niin pääset marjailemaan!</strong>
						</ul>
				        <ul>
                            <strong>Tässä tuoreimpia lisäyksiä Marjagramiin:</strong>
						</ul>
                        <ul id = "NewestImg">
                        </ul>
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
	<script src="js/main.js"></script>

<?php
    //session_start();
    //echo "<h3> PHP List All Session Variables</h3>";
    //foreach ($_SESSION as $key=>$val)
    //echo $key." ".$val."<br/>";
?>

	
	</body>
</html>
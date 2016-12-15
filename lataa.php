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
			<header><h1 id="pagetitle">Marjagram</h1></header>
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
						<form action="includes/upload.php" method="post" enctype="multipart/form-data">
						    Valitse kuva:
						    <input type="file" name="fileToUpload" id="fileToUpload" value="Valitse kuva">
						    <input type="submit" value="Lataa kuva" name="upload">
						</form>
						<?php 
						if(isset($_SESSION['message'])){
							echo($_SESSION['message']."<br>");
						}
						if($_SESSION['fileUploaded']=="yes"){
							?>
							<img src="<?php echo($_SESSION['fileName']); ?>"><br>
							<form action="includes/fileNameDesc.php" method="post">
							Kuvan nimi: <input type="text" name="newName"><br>
							Kuvan kuvaus: <input type="text" name="newDesc"><br>
						    <input type="submit" value="Päivitä kuvan tiedot" name="updateNameDesc">
							</form>
						<?php
						}
						?>
						
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
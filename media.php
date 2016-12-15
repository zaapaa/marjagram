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
		<link href="css/rating.css" rel="stylesheet">
	</head>
	<body class="blue">
		<div id="wrapper">
			<header><h1 id="pagetitle">Media</h1></header>
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
						<h1>Kommentoi ja arvostele mediaa</h1>
						<?php
						$_SESSION['mediaID'] = $_GET['id'];
						$_SESSION['dir'] = $_GET['dir'];
						?>
						<script src="js/media.js"></script>
						<ul id = "Img">
						</ul>
					</article>
					<fieldset class="rating">
					    <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
					    <input type="radio" id="star4half" name="rating" value="4.5" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
					    <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
					    <input type="radio" id="star3half" name="rating" value="3.5" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
					    <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
					    <input type="radio" id="star2half" name="rating" value="2.5" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
					    <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
					    <input type="radio" id="star1half" name="rating" value="1.5" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
					    <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
					    <input type="radio" id="starhalf" name="rating" value="0.5" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
					</fieldset>
					<p id="ratingcount"></p>
					<p id="ratingavg"></p>
					<?php echo($_SESSION['message']."<br>"); 
					?>
					<script src="js/rating.js"></script>
					<article>
					<script src="js/comment.js"></script>
					<ul id="comment">					
					</ul>
					<form method = "POST" action = "includes/newComment.php">
					<textarea name="comment" placeholder="Kommentoi kuvaa!" required ></textarea>
					<input type="submit" value="Lähetä" name="submitcomment">
					</form>
					</article>
					<?php
					$next = $_GET['id']+1;
					$previous = $_GET['id']-1;
					if($previous < 0){
						$previous = 0;
					}
					?>
					<a href="media.php?id=<?php echo($next); ?>&dir=1">Seuraava</a>
					<a href="media.php?id=<?php echo($previous); ?>&dir=-1">Edellinen</a>
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

		var stars = document.querySelectorAll('input[name="rating"]');
		
		var rate = function (value) {
		    var xhrr = new XMLHttpRequest();
		    console.log(value);
		    var valueURI = encodeURIComponent(parseFloat(value));
		    xhrr.open('GET', 'includes/newRating.php?rating=' + valueURI);
		    xhrr.send();
		}

		for (var star of stars) {
		    star.setAttribute("disabled", "true");
		}

		var labels = $('label');
		labels.each(function(){
			var self=$(this);
			if (self.prev().is('input[type="radio"]')) {
				self.click(function(){
					rate(self.prev().val());
				});
		    }
		});

		/*var disabled = $('input[type="radio"]:disabled');
		disabled.each(function () {
		    var self = $(this),
		        field = self,
		        overlay = $('<div />');
		    if (self.next().is('label')) {
		        field = self.next();
		    }
		    overlay.css({
		        position: 'absolute',
		        top: field.offset().top,
		        left: field.offset().left,
		        width: field.outerWidth(),
		        height: field.outerHeight(),
		        zIndex: 10000,
		        backgroundColor: '#ffffff',
		        opacity: 0
		    }).click(function () {
		    	return $self.trigger("click");
		    });
		    self.parent().append(overlay);
		});*/
		

	</script>
	</body>
</html>
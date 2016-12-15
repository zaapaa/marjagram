<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//This works in 5.2.3
//First function turns SSL on if it is off.
//Second function detects if SSL is on, if it is, turns it off.


//==== Redirect... Try PHP header redirect, then Java redirect, then try http redirect.:
function redirect($url){
	if (!headers_sent()){    //If headers not sent yet... then do php redirect
		header('Location: '.$url); exit;
	}else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
		echo '<script type="text/javascript">';
		echo 'window.location.href="'.$url.'";';
		echo '</script>';
		echo '<noscript>';
		echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
		echo '</noscript>'; exit;
	}
}//==== End -- Redirect

/**
 * Etsii annetun käyttäjän tiedot kannasta
 * @param $user
 * @param $pwd
 * @param $DBH
 * @return $row käyttäjäolio ,boolean false jos annettua käyttäjää ja salasanaa löydy
 */
function login($user, $pwd, $DBH) {
	// !! on suola, jotta kantaan taltioitu eri hashkoodi vaikka salasana olisi tiedossa
	//kokeile !! ja ilman http://www.danstools.com/md5-hash-generator/
	//Tukevampia salauksia hash('sha256', $pwd ) tai hash('sha512', $pwd )
	//An array of values with as many elements as there are bound parameters in the
	//SQL statement being executed. All values are treated as PDO::PARAM_STR
	$data = array('username' => $user);
	//print_r($data);
	try {
		//print_r($data);
		//echo "Login 1<br />";
		$STH = $DBH->prepare("SELECT * FROM marjagram_user WHERE Username=:username;");
		//HUOM! SQL-lauseessa on monta muuttuvaa) tietoa. Ne on helppo antaa
		// assosiatiivisen taulukon avulla (eli indeksit merkkijonoja)
		//HUOM! Taulukko annetaan nyt execute() metodille
		$STH->execute($data);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$row = $STH->fetch();
		$pwHashDB = $row->Password;
		if($STH->rowCount() > 0){
			if(password_verify($pwd, $pwHashDB)){
				return $row;
			}
			return false;
		} else {
			//echo "Login 5<br />";
			return false;
		}
	} catch(PDOException $e) {
		echo "Login DB error: ".$e->getMessage();
		file_put_contents('log/DBErrors.txt', 'Login: '.$e->getMessage()."\n", FILE_APPEND);
	}
}

function getNewestMedia($DBH, $count){
	try {
		//Haetaan $count muuttujan arvon verran uusimpia kuvia
		$mediaTuotteet = array(); //Taulukko haettaville kuva-olioille (mediatuote)


		$STH = $DBH->query("SELECT * FROM marjagram_media,marjagram_user 
				WHERE marjagram_media.UserID=marjagram_user.UserID
				ORDER BY marjagram_media.UDate DESC LIMIT $count");
		//$STH->bindParam(':count', $count);
		$STH->execute();
		$STH->setFetchMode(PDO::FETCH_OBJ);  //yksi rivi objektina
		while($mediaTuote = $STH->fetch()){
			$mediaTuotteet[] = $mediaTuote; //Lisätään objekti taulukon loppuun
		}
		return $mediaTuotteet;
	} catch(PDOException $e) {
		file_put_contents('../log/DBErrors.txt', 'getNewMedia(): '.$e->getMessage()."\n", FILE_APPEND);
		return false;
	}}
function getSearchMedia($DBH, $search){
	try {
		if(empty($search)){
			die("search empty");
		}
		//Haetaan $count muuttujan arvon verran uusimpia kuvia
		$mediaTuotteet = array(); //Taulukko haettaville kuva-olioille (mediatuote)
		
		
		$sql="SELECT DISTINCT * FROM marjagram_media,marjagram_user 
				WHERE (MName LIKE '%".$search."%' OR Description LIKE '%".$search."%') 
						AND marjagram_media.UserID=marjagram_user.UserID;";
		$STH = $DBH->prepare($sql);
		//$STH->bindParam(':count', $count);
		$STH->execute();
		$STH->setFetchMode(PDO::FETCH_OBJ);  //yksi rivi objektina
		while($mediaTuote = $STH->fetch()){
			$mediaTuotteet[] = $mediaTuote; //Lisätään objekti taulukon loppuun
		}
		return $mediaTuotteet;
	} catch(PDOException $e) {
		file_put_contents('../log/DBErrors.txt', 'getSearchMedia(): '.$e->getMessage()."\n", FILE_APPEND);
		return false;
	}
}
	
function getMediaID($DBH, $id){
	try {
		if(empty($id)){
			die("id empty");
		}
		//Haetaan $count muuttujan arvon verran uusimpia kuvia
		$mediaTuotteet = array(); //Taulukko haettaville kuva-olioille (mediatuote)


		$sql="SELECT DISTINCT * FROM marjagram_media,marjagram_user
			WHERE marjagram_media.MediaID = $id 
					AND marjagram_media.UserID=marjagram_user.UserID;";
		$STH = $DBH->prepare($sql);
		//$STH->bindParam(':count', $count);
		$STH->execute();
		$STH->setFetchMode(PDO::FETCH_OBJ);  //yksi rivi objektina
		while($mediaTuote = $STH->fetch()){
			$_SESSION['count'] = 0;
			$_SESSION['lastvalid'] = $_SESSION['mediaID'];
			$mediaTuotteet[] = $mediaTuote; //Lisätään objekti taulukon loppuun
		}
		if(empty($mediaTuotteet)){
			$oldid = $_SESSION['mediaID'];
			$newid = $oldid;
			
			if(isset($_SESSION['dir'])){
				$dir = $_SESSION['dir'];
				$_SESSION['count'] +=1;
				if($_SESSION['count'] > 10){
					$_SESSION['message'] = "Ei mediaa siinä suunnassa";
					redirect('media.php?id='.$_SESSION['lastvalid']);
				}
				$newid = $oldid + $dir;
				redirect('media.php?id='.$newid.'&dir='.$dir);
			} else {
				redirect('media.php?id='.$newid);
			}
			return false;
		}
		return $mediaTuotteet;
	} catch(PDOException $e) {
		file_put_contents('../log/DBErrors.txt', 'getSearchMedia(): '.$e->getMessage()."\n", FILE_APPEND);
		return false;
	}
}

function getComments($DBH, $id){
	try {
		if(empty($id)){
			die("id empty");
		}
		//Haetaan $count muuttujan arvon verran uusimpia kuvia
		$kommentit = array(); //Taulukko haettaville kuva-olioille (mediatuote)


		$sql="SELECT * FROM marjagram_comment, marjagram_user
		WHERE marjagram_comment.MediaID = $id 
		AND marjagram_comment.UserID=marjagram_user.UserID
		ORDER BY CommentID ASC;";
		$STH = $DBH->prepare($sql);
		//$STH->bindParam(':count', $count);
		$STH->execute();
		$STH->setFetchMode(PDO::FETCH_OBJ);  //yksi rivi objektina
		while($kommentti = $STH->fetch()){
			$kommentit[] = $kommentti; //Lisätään objekti taulukon loppuun   <asd>: kofksdofjsdoihgsdgnldrkkl
		}
		return $kommentit;
	} catch(PDOException $e) {
		file_put_contents('../log/DBErrors.txt', 'getSearchMedia(): '.$e->getMessage()."\n", FILE_APPEND);
		return false;
	}
}

function getRating($DBH, $id){
	try {
		if(empty($id)){
			die("id empty");
		}
		//Haetaan $count muuttujan arvon verran uusimpia kuvia
		$kommentit = array(); //Taulukko haettaville kuva-olioille (mediatuote)


		$sql="SELECT SUM(Rating)/COUNT(*) as avg, COUNT(*) as count FROM marjagram_rating
		WHERE marjagram_rating.MediaID = $id";
		$STH = $DBH->prepare($sql);
		//$STH->bindParam(':count', $count);
		$STH->execute();
		$STH->setFetchMode(PDO::FETCH_OBJ);  //yksi rivi objektina
		while($kommentti = $STH->fetch()){
			$kommentit[] = $kommentti; //Lisätään objekti taulukon loppuun   <asd>: kofksdofjsdoihgsdgnldrkkl
		}
		return $kommentit;
	} catch(PDOException $e) {
		file_put_contents('../log/DBErrors.txt', 'getSearchMedia(): '.$e->getMessage()."\n", FILE_APPEND);
		return false;
	}
}

	
function debug_to_console( $data ) {
	
		if ( is_array( $data ) )
			$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
			else
				$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
	
				echo $output;
}

?>
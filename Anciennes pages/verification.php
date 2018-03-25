
<?php
    session_start();
	$login = 'momo';
	$password = '1996';
	$verifPa=$_POST['password'];
	$verifLo=$_POST['login'];
	if(!isset($_SESSION["compteur"])) {
		$_SESSION["compteur"] = 0;
	}
	
		
		if ( $verifPa   == $password && $verifLo == $login && $_SESSION["compteur"]<3)  
		{ 
			echo  " Ok";
		}
		else  
		{
			if($_SESSION["compteur"]<=3){
				echo "erreur connection";
				$_SESSION['compteur']++;
				header('refresh:1;url=http://localhost/exercice33.html');
			}
			else if($_SESSION["compteur"] >= 3) {
				echo "trop de tentatives";
				$_SESSION["compteur"] = 0;
				header('refresh:1;url=http://localhost/exercice33.html');
			}
			
		}		
?>

 


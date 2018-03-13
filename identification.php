
<?php
    session_start();
	$base = new mysqli('localhost', 'root', '','lamp');
	$verifPa=$_POST['password'];
	$verifNom=$_POST['Nom'];
	$verifPrenom=$_POST['Prenom'];
	$verifemail=$_POST['email'];
	$verifdate=$_POST['date'];
	if(!isset($_SESSION["compteur"])) {
		$_SESSION["compteur"] = 0;
	}
	
	$sql='SELECT * FROM membre WHERE Pass="'.$verifPa.'" AND Nom="'.$verifNom.'" AND Prenom="'.$verifPrenom.'" AND email="'.$verifemail.'" AND BirthDate="'.$verifdate.'" AND Type="D"';
	$req = $base->query($sql);
		while($data = mysqli_fetch_array($req))  
		{ 
			if($_SESSION["compteur"]<3){
				echo  " Ok";
			}
			else  
			{
				if($_SESSION["compteur"]<=3){
					echo "erreur connection";
					$_SESSION['compteur']++;
					header('refresh:1;url=http://localhost/docteur_identification.html');
				}
				else if($_SESSION["compteur"] >= 3) {
					echo "trop de tentatives";
					$_SESSION["compteur"] = 0;
					header('refresh:1;url=http://localhost/docteur_identification.html');
				}
				
			}	
		}
?>
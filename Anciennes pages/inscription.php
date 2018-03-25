
<?php
include('function.php');
try
{
	Session_start();
	$base = new mysqli('localhost', 'root','','sante');
}
catch(Exception $e)
{
	die('Erreur:'.$e->getMessage());
}
$pass_hache= password_hash($_POST['password'],PASSWORD_DEFAULT);
$sql='INSERT INTO membre(Nom, Prenom, Pass, BirthDate, Email, Type) VALUES("'.$_POST['Nom'].'","'.$_POST['Prenom'].'","'.$pass_hache.'","'.$_POST['date'].'","'.$_POST['email'].'","'.$_POST['statut'].'")';
$req = $base->query($sql);
header('refresh:1;url=http://localhost/Acceuil.html');
?>
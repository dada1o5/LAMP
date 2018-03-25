<?php
// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['prenom']) 		||
   empty($_POST['date']) 		||
   empty($_POST['email']) 		||
   empty($_POST['mdp']) 		||
   empty($_POST['type'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }
	
$name = strip_tags(htmlspecialchars($_POST['name']));
$prenom = strip_tags(htmlspecialchars($_POST['prenom']));
$date = strip_tags(htmlspecialchars($_POST['date']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$mdp = strip_tags(htmlspecialchars($_POST['mdp']));
$type = strip_tags(htmlspecialchars($_POST['type']));	
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
$sql='INSERT INTO membre(Nom, Prenom, Pass, BirthDate, Email, Type) VALUES("'.$_POST['name'].'","'.$_POST['prenom'].'","'.$pass_hache.'","'.$_POST['date'].'","'.$_POST['email'].'","'.$_POST['type'].'")';
$req = $base->query($sql);
header('refresh:1;url=http://localhost/Acceuil.html');
?>		
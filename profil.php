 <?php

try

{

    $bdd = new PDO('mysql:host=localhost;dbname=sante;charset=utf8', 'root', '');

}

catch (Exception $e)

{

        die('Erreur : ' . $e->getMessage());

}

$reponse = $bdd->query('SELECT * FROM patient');



$reponse->closeCursor();

?>
<?php
 
// Bibliothèque nécessaire
include ("/xampp/htdocs/Lamp/jpgraph-4.2.0/src/jpgraph.php");
include ("/xampp/htdocs/Lamp/jpgraph-4.2.0/src/jpgraph_line.php");
session_start();
 
 
$bdd = new PDO('mysql:host=localhost;dbname=doclink', 'root', '');
 
// Definition des tableaux
$tableaunumboulon = [1,2,3,4];
$tableaucoupledetecte = [1,2,3,4]; 

// requete des données
$reqmail = $bdd->prepare("SELECT id FROM utilisateurs ");
$reqmail->execute($tableaunumboulon);


 

 
// ***********************
// Création du graphique
// ***********************
 
// Création du conteneur
$graph = new Graph(1000,600);
 
// Fixer les marges
$graph->img->SetMargin(40,30,50,40);   
 
// Mettre une image en fond
// $graph->SetBackgroundImage("images/mael_white.png",BGIMG_FILLFRAME);
 
// Lissage sur fond blanc (évite la pixellisation)
$graph->img->SetAntiAliasing("white");
 
// A détailler
$graph->SetScale("textlin");
 
// Ajouter une ombre
$graph->SetShadow();
 
// Ajouter le titre du graphique
$graph->title->Set("Données du patient ");
 
// Afficher la grille de l'axe des ordonnées
$graph->ygrid->Show();
// Fixer la couleur de l'axe (bleu avec transparence : @0.7)
$graph->ygrid->SetColor('blue@0.7');
// Des tirets pour les lignes
$graph->ygrid->SetLineStyle('dashed');
 
// Afficher la grille de l'axe des abscisses
$graph->xgrid->Show();
// Fixer la couleur de l'axe (rouge avec transparence : @0.7)
$graph->xgrid->SetColor('red@0.7');
// Des tirets pour les lignes
$graph->xgrid->SetLineStyle('dashed');
 
// Apparence de la police
$graph->title->SetFont(FF_ARIAL,FS_BOLD,11);
 
// Créer une courbes
$courbe = new LinePlot($tableaunumboulon, $tableaucoupledetecte);
 
// Afficher les valeurs pour chaque point
$courbe->value->Show();
 
// Valeurs: Apparence de la police
$courbe->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$courbe->value->SetFormat('%d');
$courbe->value->SetColor("red");
 
// Chaque point de la courbe ****
// Type de point
$courbe->mark->SetType(MARK_FILLEDCIRCLE);
// Couleur de remplissage
$courbe->mark->SetFillColor("green");
// Taille
$courbe->mark->SetWidth(5);
 
// Couleur de la courbe
$courbe->SetColor("blue");
$courbe->SetCenter();
 
// Paramétrage des axes

$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetTickLabels($tableaunumboulon);
 
// Ajouter la courbe au conteneur
$graph->Add($courbe);
 
$graph->Stroke();
 
?>
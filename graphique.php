<?php



// Connexion à la base de données


$bdd = new PDO('mysql:host=localhost;dbname=doclink','root','');


// Requête SQL permettant la création de notre camembert

$query = $bdd->prepare("SELECT col1,col2 FROM graph ");
$query->execute();




// Récupère le nombre total de posts

$requser = $bdd->prepare("SELECT SUM(col1) AS nb_posts FROM graph");
$requser->execute();
$query_nb_total_posts = $requser->fetch();

$nb_total_posts = $query_nb_total_posts['nb_posts'];



// Défini le nom de notre fonction JS et l'id du div HTML dans lequel se trouvera le camembert

$name_chart = "nb_post_users"; 

?>

<html>

  <head>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <script type="text/javascript">

      google.load("visualization", "1", {packages:["corechart"]});

      google.setOnLoadCallback(<?php echo $name_chart; ?>);

      function <?php echo $name_chart; ?>() {

        var data = new google.visualization.DataTable();

		// Nous n'avons que 2 légendes : le nom d'utilisateur (type string) et son nombre de posts (type number)

        data.addColumn('string', 'Nom');

        data.addColumn('number', 'Nombre de posts');

        data.addRows([

		<?php 

		$sum_nb_posts = '0'; // Initialisation du compteur de posts

		

		// Boucle de la requête SQL

		while ($donnees = mysql_fetch_array($query))

			{

			$username = addslashes($donnees['username']); // On oublie pas addslashes pour éviter qu'un guillemet provoque une erreur

			$nb_posts = intval($donnees['nb_posts']);

			

			$sum_nb_posts = $sum_nb_posts + $nb_posts; // Cumule le nombre de posts

			

			$data .= "['".$username." : ".$nb_posts."', ".$nb_posts."],"; // J'ai choisi d'afficher la valeur directement dans la légende en écrivant '".$username." : ".$nb_posts."'

			}

		echo $data;

		

		// Calcul et affichage du nombre de posts dont les auteurs ne sont pas dans le top

		$nb_restant_posts = $nb_total_posts - $sum_nb_posts;

		echo "['Autres utilisateurs : ".$nb_restant_posts."', ".$nb_restant_posts."]";

		?>

        ]);

		// Modifiez les options à votre convenance

        var options = {

          width: 450, height: 300,

          title: 'Top du nombre de posts par utilisateur'

        };

		

		// Affichage du camembert généré dans le div défini au début

        var chart = new google.visualization.PieChart(document.getElementById('<?php echo $name_chart; ?>'));

        chart.draw(data, options);

      }

    </script>

  </head>

  <body>

	<!-- Affichage du camembert -->

    <div id="<?php echo $name_chart; ?>"></div>

  </body>

</html>
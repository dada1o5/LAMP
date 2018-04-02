<?php

session_start();

$bdd = new PDO('mysql:host=localhost;dbname=doclink', 'root', '');

if(isset($_GET['id_utilisateur']) AND $_GET['id_utilisateur']>0)
{
	$getid = intval($_GET['id_utilisateur']);
	$requser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_utilisateur=?');
	$requser->execute(array($getid));
	$userinfo = $requser->fetch();

	$reqpatients = $bdd->query('SELECT * FROM utilisateurs');
	
	$analyse = $bdd->query('SELECT * FROM graph');
	
	
	if(!isset($_POST['comment']))
	{
		
		$commentaire = htmlspecialchars($_POST['message']);
		$ajoutcommentaire = $bdd->prepare("INSERT INTO analyse(commentaire, id_utilisateur) VALUES(?,?)");
		$ajoutcommentaire->execute(array($commentaire,$_SESSION['id_utilisateur']));
	}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Page Docteur</title>
  <!-- Fichier bootstrap CSS -->
		<link href="bootstrap/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Polices -->
		<link href="bootstrap/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <!-- Plugin CSS -->
		<link href="bootstrap/vendor/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">
  <!-- Bootstrap core CSS-->
  <link href="bootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="bootstrap/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="bootstrap/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="accueil_docteur.css" rel="stylesheet">
   
</head>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Barre de Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary fixed-top" id="mainNav">
		<a class="navbar-brand" href="analyse_docteur.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">DocLink</a>
	<div id="logo">
			<img src="Images/logo.png" alt="Medlink" />
		</div>
	<!--Bouton pour petit ecran-->
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse bg-secondary" id="navbarResponsive">
	<!--Barre de navigation coté gauche-->
      <ul class="navbar-nav navbar-sidenav bg-secondary" id="exampleAccordion">
	  <!--Tableau de bord-->
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tableau de bord">
          <a class="nav-link" href="accueil_docteur.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Tableau de bord</span>
          </a>
        </li>
        <!--Mes analyses-->
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Analyse">
          <a class="nav-link" href="analyse_docteur.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Mes analyses patients</span>
          </a>
        </li>
		<!--Mes rendez-vous-->
	   <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Rendez vous">
          <a class="nav-link" href="rdv_docteur.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Mes rendez-vous</span>
          </a>
        </li>
        <!--Mon profil-->
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Profil">
          <a class="nav-link" href="profil_docteur.php">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Mon Profil</span>
          </a>
        </li>

        <!--Mes patients-->
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Patients">
          <a class="nav-link" href="ListePatients.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">
            <i class="fa fa-fw fa-address-book"></i>
            <span class="nav-link-text">Mes patients</span>
          </a>
        </li>
      </ul>

      <!--Bouton fleche du bas-->
	  <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
     <!--Barre du haut-->
	 <ul class="navbar-nav ml-auto">
	 <!--Menu déroulant messages-->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-envelope"></i>
            <span class="d-lg-none">
			Messages
            </span>
            <span class="indicator text-primary d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="messagesDropdown">
            <h6 class="dropdown-header">Nouveaux messages:</h6>
		
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="messagerie_docteur.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">Voir tout les messages</a>
          </div>
        </li>
        
        <!--Bienvenue-->
		<li class="nav-item">
          <h3 class="text-white">Bienvenue <?php echo $userinfo['prenom']; ?> !</h3>
        </li>
        <!--Bouton deconnexion-->
		<li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Déconnexion</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- Contenu de la page A MODIFIER-->
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Analyse Patient</a>
        </li>
        <li class="breadcrumb-item active"></li>
      </ol>

      <!--Sélection patient menu déroulant-->
      <div class="dropdown">
        <span class="caret"></span></button>
        <label>Patients :</label>
		<select name="patients">
			<?php
			while ($donnees = $reqpatients->fetch()){
			if($donnees['statut']=='Patient')
			{
			?>
			<option><?php echo " ".$donnees['prenom']." ".$donnees['nom']."<br>"; ?></option>
			<?php
			}
		}
		?>
		</select>
		<input type="submit" value="Valider" name="select_patient" />
      </div>
	  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
      
	var data = google.visualization.arrayToDataTable([
          ['col1', 'col2'],
	  <?php
		$nbr=0;
		$echo = "";
		while ($Camp = $analyse->fetch(PDO::FETCH_ASSOC)) {
		$nbr++;
		$echo .= "['".$Camp['col2']."', ".$Camp['col1']."],";
		}
		echo substr($echo,0,-1); // on enlve la virgule de la fin
		?>]);

				
        

        var options = {
          title: 'Analyse ',
          hAxis: {title: 'date',  titleTextStyle: {color: '#333'}},
          
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
<div id="chart_div" style="width: 100%; height: 500px;"></div>

<div id="container">
<h2>Commentaires</h2>
<form method="post" action="analyse_docteur.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">

             <textarea  name="message" rows="4" cols="100"></textarea>
			 
             <br />
			  <br />
             <input id ="comment" type="submit" value="Envoyer" />
           </p>
         </form>
         <p></p>
</div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © DocLink 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Déconnexion Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Voulez vous vous déconnecter ?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Cliquez sur "Déconnexion" pour quitter cette session</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
            <a class="btn btn-primary" href="deconnexion.php">Déconnexion</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="bootstrap/vendor/jquery/jquery.min.js"></script>
    <script src="bootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="bootstrap/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="bootstrap/vendor/chart.js/Chart.min.js"></script>
    <script src="bootstrap/vendor/datatables/jquery.dataTables.js"></script>
    <script src="bootstrap/vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="bootstrap/js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="bootstrap/js/sb-admin-datatables.min.js"></script>
    <script src="bootstrap/js/sb-admin-charts.min.js"></script>
  </div>
</body>

</html>
<?php
}
?>

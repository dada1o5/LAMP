<?php

session_start();

$bdd = new PDO('mysql:host=localhost;dbname=doclink', 'root', '');

if(isset($_GET['id_utilisateur']) AND $_GET['id_utilisateur']>0)
{
	$getid = intval($_GET['id_utilisateur']);
	$requser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_utilisateur=?');
	$requser->execute(array($getid));
	$userinfo = $requser->fetch();
	
	if(isset($_POST['valider_message']))
	{
		$message = htmlspecialchars($_POST['message']);
		
		$ins = $bdd->prepare('INSERT INTO messages(id_exp,id_dest,message) VALUES (?,?,?)');
		$ins->execute(array($_SESSION['id_utilisateur'],$_POST['destinataire'],$message));
	}
	
	$msg = $bdd->prepare('SELECT * FROM messages WHERE id_dest=?');
    $msg->execute(array($_SESSION['id_utilisateur']));
    $msg_nbr = $msg->rowCount();
	
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Page Patient</title>
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
  <link href="Patient.css" rel="stylesheet">
</head>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Barre de Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary fixed-top" id="mainNav">
    <a class="navbar-brand" href="Patients.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">DocLink</a>
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
          <a class="nav-link" href="Patients.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Tableau de bord</span>
          </a>
        </li>
        <!--Mes relevés-->
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Relevés">
          <a class="nav-link" href="releves.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Mes relevés</span>
          </a>
        </li>
		<!--Mes rendez-vous-->
	   <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Rendez vous">
          <a class="nav-link" href="rdv_patient.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Mes rendez-vous</span>
          </a>
        </li>
        <!--Mon profil-->
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Profil">
          <a class="nav-link" href="profil.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Mon Profil</span>
          </a>
        </li>
        <!--Mes ordonnances-->
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Ordonnances">
          <a class="nav-link" href="ordonnance.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Mes ordonnances</span>
          </a>

        </li>
        <!--Mes medecins-->
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Medecins">
          <a class="nav-link" href="ListeMedecins.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">
            <i class="fa fa-fw fa-address-book"></i>
            <span class="nav-link-text">Mes médecins</span>
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
			<!--Permet de diviser les élements-->
            
            <div class="dropdown-divider"></div>
             <a class="dropdown-item small" href="messagerie_patient.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">Voir tout les messages</a>
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
          <a href="#">Mes message</a>
        </li>
      </ol>
		

      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header lead text-left text-info col-lg-12 ml-auto">
          <i class="fa fa-fw fa-envelope"></i> Mes messages</div>
        <div class="card-body">
			<?php
			
			if($msg_nbr == 0) { echo "Vous n'avez aucun message !"; }
			while($m = $msg->fetch()) { 
				
				$p_exp = $bdd->prepare('SELECT prenom,nom FROM utilisateurs WHERE id_utilisateur=?');
				$p_exp->execute(array($m['id_exp']));
				$p_exp = $p_exp->fetch();
			?>

			<b><?php echo $p_exp['prenom']." ".$p_exp['nom']; ?></b> vous a envoyé : <br/>
			<?= nl2br($m['message']); ?> <br><br><br>
	
		
			<?php } ?>
			
		
		</div>
		
		</div>
		   <div class="card mb-3">
        <div class="card-header lead text-left text-info col-lg-12 ml-auto">
          <a class="text-white btn btn-secondary" data-toggle="modal" data-target="#nouveau_message"><i class="fa fa-fw fa-edit"></i> Écrire un nouveau message</a></div>
		  
		
		</div>
    </div>
        
       
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
	<!--Popup nouveau message-->
	<div class="modal fade" id="nouveau_message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Écrire un nouveau message</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
		  
			<?php $reponse = $bdd->query('SELECT * FROM utilisateurs'); ?>
			<form method="post" enctype="multipart/form-data">
			<div class="form-group">
			<label for="destinataire">Destinataire :</label><br />
			<select class="form-control" name="destinataire" id="destinataire">
				<?php
				while ($donnees = $reponse->fetch()){  
					if($donnees['statut']=='Docteur')
					{
					$reqfollow = $bdd->prepare('SELECT * FROM follow WHERE id_abonne=? AND id_suivi=?');
					$reqfollow->execute(array($_SESSION['id_utilisateur'],$donnees['id_utilisateur']));
					$follow_exist = $reqfollow->rowCount();
					
					if($follow_exist == 1)
					{
				?>
					<option> Choisissez votre destinataire </option>
					<option value="<?php echo $donnees['id_utilisateur']; ?>"><?php echo $donnees['prenom']." ".$donnees['nom']; ?></option>
					<?php } } }
			?>	
			</select>
					<br />
			<label for="message">Votre message :</label><br />
			<textarea name="message" id="message" rows="5" cols="50" /></textarea><br />
		 </div>
		 </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
            <!--<a class="btn btn-primary" href="profil.php?id_utilisateur?">Enregistrer</a>-->
			<button type="submit" class="btn btn-primary btn-xl" name="valider_message" id="valider_message">Enregister</button>
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

<?php

session_start();

$bdd = new PDO('mysql:host=localhost;dbname=doclink', 'root', 'root');

if(isset($_GET['id_utilisateur']) AND $_GET['id_utilisateur']>0)
{
	$getid = intval($_GET['id_utilisateur']);
	$requser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_utilisateur=?');
	$requser->execute(array($getid));
	$userinfo = $requser->fetch();

	if(isset($_POST['valider']))
	{
		if(isset($_FILES['profil']) AND !empty($_FILES['profil']['name']))
		{
			$tailleMax = 2097152;
			$extensionValides = array('jpg','jpeg','gif','png');
			if($_FILES['profil']['size']<= $tailleMax)
			{
				$extensionUpload = strtolower(substr(strrchr($_FILES['profil']['name'],'.'),1));
				if(in_array($extensionUpload, $extensionValides))
				{
					$chemin = "membres/avatars/".$_SESSION['id_utilisateur'].".".$extensionUpload;
					$resultat = move_uploaded_file($_FILES['profil']['tmp_name'],$chemin);
					if($resultat)
					{
						$updatephoto = $bdd->prepare('UPDATE utilisateurs SET avatar=? WHERE id_utilisateur=?');
						$updatephoto->execute(array($_SESSION['id_utilisateur'].".".$extensionUpload,$_SESSION['id_utilisateur']));
						header("Location:profil_docteur.php?id_utilisateur=".$_SESSION['id_utilisateur']);
					}
					else
					{
						echo "Erreur pendant l'importation de la photo !";
					}
				}
				else
				{
					echo "Votre photo doit être au format jpg, jpeg, gif ou png !";
				}
			}
			else
			{
				echo "Votre photo ne doit pas dépasser 2Mo !";
			}
		}
	}

	if(isset($_POST['valider_maj']))
	{

		if(isset($_POST['email']) AND !empty($_POST['email']))
		{
			$nouvmail = htmlspecialchars($_POST['email']);
			$insertmail = $bdd->prepare("UPDATE utilisateurs SET email = ? WHERE id_utilisateur = ?");
			$insertmail->execute(array($nouvmail,$_SESSION['id_utilisateur']));
			header('Location:profil_docteur.php?id_utilisateur='.$_SESSION['id_utilisateur']);
		}
		if(isset($_POST['mdp']) AND !empty($_POST['mdp']) AND isset($_POST['mdp2']) AND !empty($_POST['mdp2']) AND isset($_POST['conf_mdp2']) AND !empty($_POST['conf_mdp2']))
		{
			$mdp = sha1($_POST['mdp']);
			$mdp2 = sha1($_POST['mdp2']);
			$conf_mdp2 = sha1($_POST['conf_mdp2']);

			if($mdp == $userinfo['mdp'])
			{
				if($mdp2 == $conf_mdp2)
				{
					$modifmdp=$bdd->prepare("UPDATE utilisateurs SET mdp=? WHERE id_utilisateur=?");
					$modifmdp->execute(array($mdp2,$_SESSION['id_utilisateur']));
					header('Location:profil_docteur.php?id_utilisateur='.$_SESSION['id_utilisateur']);
				}
			}
		}

		if(!empty($_POST['date']))
		{
			$date = htmlspecialchars($_POST['date']);
			$modifdate = $bdd->prepare("UPDATE utilisateurs SET date = ? WHERE id_utilisateur = ?");
			$modifdate->execute(array($date,$_SESSION['id_utilisateur']));
			header('Location:profil_docteur.php?id_utilisateur='.$_SESSION['id_utilisateur']);
		}
		if(!empty($_POST['lieu']))
		{
			$lieu = htmlspecialchars($_POST['lieu']);
			$modiflieu = $bdd->prepare("UPDATE utilisateurs SET lieu_naissance = ? WHERE id_utilisateur = ?");
			$modiflieu->execute(array($lieu,$_SESSION['id_utilisateur']));
			header('Location:profil_docteur.php?id_utilisateur='.$_SESSION['id_utilisateur']);
		}
		if(!empty($_POST['numero_cps']))
		{
			$numero_secu = htmlspecialchars($_POST['numero_cps']);
			$modifns = $bdd->prepare("UPDATE utilisateurs SET numero_cps = ? WHERE id_utilisateur = ?");
			$modifns->execute(array($numero_secu,$_SESSION['id_utilisateur']));
			header('Location:profil_docteur.php?id_utilisateur='.$_SESSION['id_utilisateur']);
		}
		if(!empty($_POST['specialites']))
		{
			$numero_secu = htmlspecialchars($_POST['specialites']);
			$modifns = $bdd->prepare("UPDATE utilisateurs SET specialites = ? WHERE id_utilisateur = ?");
			$modifns->execute(array($numero_secu,$_SESSION['id_utilisateur']));
			header('Location:profil_docteur.php?id_utilisateur='.$_SESSION['id_utilisateur']);
		}
	}



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
	<!--php-->
		<link rel="stylesheet" href="patient.php" />
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
  <link href="profil_docteur.css" rel="stylesheet">
</head>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Barre de Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary fixed-top" id="mainNav">
    <a class="navbar-brand" href="accueil_docteur.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">DocLink</a>
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
      <a class="nav-link" href="profil_docteur.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">
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
			<!--Permet de diviser les élements-->
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>David Miller</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>Jane Smith</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>John Doe</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">Voir tout les messages</a>
          </div>
        </li>
        <!--Menu déroulant alertes-->
		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="d-lg-none">
			Alertes
            </span>
            <span class="indicator text-warning d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">Nouvelles Alertes:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-danger">
                <strong>
                  <i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">Voir toutes les alertes</a>
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
          <a href="#">Mon profil</a>
        </li>
		<li class="breadcrumb-item active"> Mes informations</li>
      </ol>

      <!-- Example DataTables Card-->

	   <!--Mon profil-->

	 <section id="inscrire">
	<div class="container">

		<h2 class="text-center text-uppercase text-secondary mb-0"><?php echo $userinfo['prenom']." ".$userinfo['nom']; ?></h2>

		<div id="photo" >
		<?php
		if ($avatar['avatar'] == NULL)
		{
		?>
			<a class="nav-link" data-toggle="modal" data-target="#profilModal"><img class="ronded-circle w-100 " src="membres/avatars/default.png" alt=""></a>
		<?php
		}
		else
		{
		?>
        <a class="nav-link" data-toggle="modal" data-target="#profilModal"><img class="rounded-circle w-100 " src="membres/avatars/<?php echo $userinfo['avatar']; ?>" alt=""></a>
		<?php
		}
		?>
	   </div>

		<div class="row">

		<div class="lead text-left text-info col-lg-12 ml-auto">
			<?php echo '<br>'; ?>
		Date de naissance : <?php echo $userinfo['date']; ?>
		<hr class="barre-dark ">
		</div>
			<div class="lead text-left text-info col-lg-12 ml-auto">
			Adresse e-mail : <?php echo $userinfo['email']; ?>
			<hr class="barre-dark ">
			</div>
			<div class="lead text-left text-info col-lg-12 ml-auto">
			Sexe :  <?php echo $userinfo['sexe']; ?>
			<hr class="barre-dark">
			</div>


		<div class="lead text-left text-info col-lg-12 ml-auto">
		Lieu de naissance : <?php if($userinfo['lieu_naissance']==NULL) { echo "inconnu"; } else echo $userinfo['lieu_naissance']; ?>
		<hr class="barre-dark ">
		</div>
		<div class="lead text-left text-info col-lg-12 ml-auto">
		Carte CPS : <?php if($userinfo['numero_cps']==NULL) { echo "inconnu"; } else echo $userinfo['numero_cps']; ?>
		<hr class="barre-dark">
		</div>


		<div class="lead text-left text-info col-lg-12 ml-auto">
		Mes spécialités : <?php if($userinfo['specialites']==NULL) { echo "inconnu"; } else echo $userinfo['specialites']; ?>
		<hr class="barre-dark ">
		</div>

	</div>
<br>
		<div class="row">
		<div class="lead text-center col-lg-12 ml-auto">
		<!--<a class="nav-link" data-toggle="modal" data-target="#maj"><button type="submit" class="btn btn-primary btn-xl" name="maj" id="maj">Mettre à jour mes infos</button></a>-->
		<a class="text-white btn btn-secondary" data-toggle="modal" data-target="#maj"><i class="fa fa-fw fa-sign-out"></i>Mettre à jour mes infos</a>
		</div>
		</div>
		<br><br>

        </div>
    </div>
   </section>
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
	<!-- Changer photo profil-->
    <div class="modal fade" id="profilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Changez votre photo de profil</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
			<form method="post" enctype="multipart/form-data">
			<label for="profil">Icône du fichier (JPG, PNG ou GIF | max. 15 Ko) :</label><br />
			<input type="file" name="profil" id="profil" /><br />
		  </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
            <!--<a class="btn btn-primary" href="profil.php?id_utilisateur?">Enregistrer</a>-->
			<button type="submit" class="btn btn-primary btn-xl" name="valider" id="valider">Enregister</button>
          </div>
        </div>
      </div>
    </div>
	<!--Mettre à jour infos-->
	<div class="modal fade" id="maj" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Mettre à jour vos informations</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
			<form method="post" enctype="multipart/form-data">
			<div class="form-group">
			<label for="email">Adresse e-mail :</label><br />
			<input type="mail" name="email" id="email" placeholder="<?php echo $userinfo['email'];  ?>" /><br />
			<label for="mdp">Mot de passe :</label><br />
			<input type="password" name="mdp" id="mdp" /><br />
			<label for="mdp2">Nouveau mot de passe :</label><br />
			<input type="password" name="mdp2" id="mdp2" /><br />
			<label for="conf_mdp2">Confirmer le nouveau mot de passe :</label><br />
			<input type="password" name="conf_mdp2" id="conf_mdp2" /><br /><br/><br/>

			<label for="date">Date de naissance :</label><br />
			<input type="date" name="date" id="date" placeholder="<?php echo $userinfo['date'];  ?>" /><br />
			<label for="lieu">Lieu de naissance :</label><br/>
			<input type="text" name="lieu" id="lieu" <?php if($userinfo['lieu_naissance'] != NULL) { ?> placeholder="<?php echo $userinfo['lieu_naissance']; } ?>"></br>
			<label for="numero_secu">Carte CPS :</label><br/>
			<input type="text" name="numero_cps" id="numero_cps" <?php if($userinfo['numero_cps'] != NULL) { ?> placeholder="<?php echo $userinfo['numero_cps']; } ?>"></br>
			<label for="allergies">Mes spécialités :</label><br />
			<input type="text" name="specialites" id="specialites" <?php if($userinfo['specialites'] != NULL) { ?> placeholder="<?php echo $userinfo['specialites']; } ?>"></br>


		 </div>
		 </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
            <!--<a class="btn btn-primary" href="profil.php?id_utilisateur?">Enregistrer</a>-->
			<button type="submit" class="btn btn-primary btn-xl" name="valider_maj" id="valider_maj">Enregister</button>
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

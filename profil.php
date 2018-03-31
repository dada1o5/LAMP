<?php

session_start();

$bdd = new PDO('mysql:host=localhost;dbname=doclink', 'root', '');

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
						header("Location:profil.php?id_utilisateur=".$_SESSION['id_utilisateur']);
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
$reqavatar = $bdd->prepare('SELECT avatar FROM utilisateurs WHERE id_utilisateur=?');
$reqavatar->execute(array($_SESSION['id_utilisateur']));
$avatar = $reqavatar->fetch();

	if(isset($_POST['valider_maj']) AND !empty($_POST['email']))
	{
		$nouvmail = htmlspecialchars($_POST['email']);
		$insertmail = $bdd->prepare("UPDATE utilisateurs SET email = ? WHERE id_utilisateur = ?");
		$insertmail->execute(array($nouvmail,$_SESSION['id_utilisateur']));
		header('Location:profil.php?id_utilisateur='.$_SESSION['id_utilisateur']);
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
  <link href="profil.css" rel="stylesheet">
</head>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Barre de Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary fixed-top" id="mainNav">
    <a class="navbar-brand" href="Patient.html">DocLink</a>
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
          <a class="nav-link" href="tables.php?id_utilisateur=<?php echo $_SESSION['id_utilisateur']; ?>">
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
          <a href="#">Tableau de bord</a>
        </li>
        <li class="breadcrumb-item active">Mon tableau de bord</li>
		<li class="breadcrumb-item active"> Mon profil</li>
      </ol>

      <!-- Example DataTables Card-->

	   <!--Mon profil-->

	 <section id="inscrire">
	<div class="container">
		<h2 class="text-center text-uppercase text-secondary mb-0">Mes informations</h2>
		<hr class="barre-dark mb-5">
		<h2 class="text-center text-uppercase text-secondary mb-0"><?php echo $userinfo['prenom']." ".$userinfo['nom']; ?></h2>
		<div class="card mb-3">
		<div id="photo" >
		<?php 
		if ($avatar['avatar'] == NULL)
		{
		?>
			<a class="nav-link" data-toggle="modal" data-target="#profilModal"><img class="card-img-top img-fluid w-100" src="membres/avatars/default.png" alt=""></a>
		<?php
		}
		else 
		{
		?>
        <a class="nav-link" data-toggle="modal" data-target="#profilModal"><img class="card-img-top img-fluid w-100" src="membres/avatars/<?php echo $userinfo['avatar']; ?>" alt=""></a>
		<?php
		}
		?>
	   </div>
	   </div>
		
		
		Date de naissance : <?php echo $userinfo['date']; ?></br>
		Adresse e-mail : <?php echo $userinfo['email']; ?></br>
		Sexe : <br>
		Lieu de Naissance : <?php if($userinfo['lieu_naissance']==NULL) { echo "inconnu"; } else echo $userinfo['lieu_naissance']; ?> <br>
		Numéro de sécurité sociale : <?php if($userinfo['numero_secu']==NULL) { echo "inconnu"; } else echo $userinfo['numero_secu']; ?> <br><br>
		
		<!--<a class="nav-link" data-toggle="modal" data-target="#maj"><button type="submit" class="btn btn-primary btn-xl" name="maj" id="maj">Mettre à jour mes infos</button></a>-->
		<a class="nav-link" data-toggle="modal" data-target="#maj"><i class="fa fa-fw fa-sign-out"></i>Mettre à jour mes infos</a>
		<br><br>
		
		<h3> ALLERGIES </h3><br><br>
		
		<button type="submit" class="btn btn-primary btn-xl" name="valider_allergies" id="valider_allergies">Ajouter une allergie</button>
		
		
		<br><br>
		
		<h3> PATHOLOGIES </h3><br><br>
		
		<button type="submit" class="btn btn-primary btn-xl" name="valider_pathologies" id="valider_pathologies">Ajouter une pathologie</button>
		
		<br><br>
		
		<h3> VACCINS </h3><br><br>
	
		<button type="submit" class="btn btn-primary btn-xl" name="valider_vaccins" id="valider_vaccins">Ajouter un vaccin</button>
		
		<br><br>
		
			
		<!--<div class="col-lg-8 mx-auto">
			<form name="inscription" id="inscriptionForm" novalidate="novalidate">
				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Nom</label>
                  <input class="form-control" id="Nom" type="text" placeholder= "" required="required" data-validation-required-message="Entrez votre nom.">
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Prénom</label>
                  <input class="form-control" id="Prenom" type="text" placeholder="Prénom" required="required" data-validation-required-message="Entrez votre prénom.">
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Date de naissance</label>
                  <input class="form-control" id="Date" type="date" required="required" data-validation-required-message="Entrez votre date de naissance.">
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<div class="control-group">
                <div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Adresse mail</label>
                  <input class="form-control" id="Email" type="email" placeholder="Adresse mail" required="required" data-validation-required-message="Entrez votre Email.">
                  <p class="help-block text-danger"></p>
                </div>
				</div>

				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Groupe sanguin</label>
                  <input class="form-control" id="Sang" type="text" placeholder= "" required="required" data-validation-required-message="Entrez votre nom.">
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Taille</label>
                  <input class="form-control" id="Taille" type="text" placeholder= "" required="required" data-validation-required-message="Entrez votre nom.">
                  <p class="help-block text-danger"></p>
                </div>
				</div><div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Poids</label>
                  <input class="form-control" id="Poids" type="text" placeholder= "" required="required" data-validation-required-message="Entrez votre nom.">
                  <p class="help-block text-danger"></p>
                </div>
				</div><div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Medecin généraliste</label>
                  <input class="form-control" id="Medecin" type="text" placeholder= "" required="required" data-validation-required-message="Entrez votre nom.">
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Maladie récurrente</label>
                  <input class="form-control" id="Maladie" type="text" placeholder= "" required="required" data-validation-required-message="Entrez votre nom.">
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Numéro de sécurité social</label>
                  <input class="form-control" id="SS" type="text" placeholder= "" required="required" data-validation-required-message="Entrez votre nom.">
                  <p class="help-block text-danger"></p>
                </div>
				</div>

				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Nouveau mot de passe</label>
                  <input class="form-control" id="inscriptionPassword" type="password" placeholder="Mot de passe" required="required" data-validation-required-message="Entrez votre mot de passe.">
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Confirmer mot de passe</label>
                  <input class="form-control" id="inscriptionPassword" type="password" placeholder="Mot de passe" required="required" data-validation-required-message="Entrez votre mot de passe.">
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<br>
				<div id="success"></div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-xl" id="Button">Soumettre</button>
				</div>
            </form>
        </div>-->
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
			<label for="email">Adresse e-mail :</label><br />
			<input type="mail" name="email" id="email" placeholder="<?php echo $userinfo['email'];  ?>" /><br />
			<label for="mdp">Mot de passe :</label><br />
			<input type="password" name="mdp" id="mdp" /><br />
			<label for="mdp2">Nouveau mot de passe :</label><br />
			<input type="password" name="mdp2" id="mdp2" /><br />
			<label for="conf_mdp2">Confirmer le nouveau mot de passe :</label><br />
			<input type="password" name="conf_mdp2" id="conf_mdp2" /><br /><br/><br/>
			
			<label for="lieu">Lieu de naissance :</label><br/>
			<input type="text" name="lieu" id="lieu" <?php if($userinfo['lieu_naissance'] != NULL) { ?> placeholder="<?php $userinfo['lieu_naissance']; } ?>"><br/>
			<label for="numero_secu">Numéro de sécurité social :</label><br/>
			<input type="text" name="numero_secu" id="numero_secu" <?php if($userinfo['numero_secu'] != NULL) { ?> placeholder="<?php $userinfo['numero_secu']; } ?>"></br>
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

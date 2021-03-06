<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=doclink','root','root');

if(isset($_POST['sendinscriptionButton']))
{
	$nom = htmlspecialchars($_POST['nom']);
	$prenom = htmlspecialchars($_POST['prenom']);
	$date = htmlspecialchars($_POST['date']);
	$email = htmlspecialchars($_POST['email']);
	$mdp = sha1($_POST['mdp']);
	$conf_mdp = sha1($_POST['conf_mdp']);
	$statut = htmlspecialchars($_POST['statut']);

	if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['date']) AND !empty($_POST['email']) AND !empty($_POST['mdp']) AND !empty($_POST['conf_mdp']) AND !empty($_POST['statut']))
	{
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$reqmail = $bdd->prepare("SELECT * FROM utilisateurs WHERE email=?");
			$reqmail->execute(array($email));
			$mailexist=$reqmail->rowCount();

			if($mailexist==0)
			{
				if($mdp == $conf_mdp)
				{
					$insertmbr = $bdd->prepare("INSERT INTO utilisateurs(nom, prenom, date, email,mdp, conf_mdp, statut) VALUES(?, ?, ?, ?, ?, ?, ?)");
					$insertmbr->execute(array($nom, $prenom, $date, $email, $mdp, $conf_mdp, $statut));

					$requser = $bdd->prepare('SELECT * FROM utilisateurs WHERE email=?');
					$requser->execute(array($email));
					$userinfo = $requser->fetch();

					if($statut=='Docteur')
					{
						header("Location:accueil_docteur.php?id_utilisateur=".$userinfo['id_utilisateur']);
					}

					if($statut=='Patient')
					{
						header("Location:Patients.php?id_utilisateur=".$userinfo['id_utilisateur']);
					}

				}
			}
			else
			{
				$erreur_ins = "Cette adresse e-mail est déjà utilisée !";
			}
		}
		else
		{
			$erreur_ins = "Votre adresse e-mail n'est pas valide !";
		}
	}
	else
	{
		$erreur_ins = "Veuillez remplir tous les champs !";
	}
}

if(isset($_POST['connect']))
{
	$emailconnect = htmlspecialchars($_POST['connexionemail']);
	$mdpconnect = sha1($_POST['connexionmdp']);

	if(!empty($emailconnect) AND !empty($mdpconnect))
	{
		$requser= $bdd->prepare("SELECT * FROM utilisateurs WHERE email=? AND mdp=?");
		$requser->execute(array($emailconnect, $mdpconnect));
		$userexist= $requser->rowCount();

		if($userexist == 1)
		{
			$userinfo = $requser->fetch();

			$_SESSION['id_utilisateur']=$userinfo['id_utilisateur'];
			$_SESSION['email']=$userinfo['email'];

			if($userinfo['statut']=='Docteur')
			{
				header("Location:accueil_docteur.php?id_utilisateur=".$_SESSION['id_utilisateur']);
			}

            if($userinfo['statut']=='Patient')
			{
				header("Location:Patients.php?id_utilisateur=".$_SESSION['id_utilisateur']);
			}

		}
		else
		{
			echo " Vous avez entré les mauvais identifiants !";
		}
	}
	else
	{
		echo "Tous les champs doivent être complétés !";
	}
}


?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Page d'accueil">
    <meta name="author" content="David THEBAUD">
    <title>Accueil</title>
    <!-- Fichier bootstrap CSS -->
		<link href="bootstrap/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Polices -->
		<link href="bootstrap/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <!-- Plugin CSS -->
		<link href="bootstrap/vendor/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">
    <!-- Fichier CSS -->
		<link href="Accueil.css" rel="stylesheet">
  </head>
  <body id="page-top">
    <!-- Barre de Navigation -->
    <nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">DocLink</a>
		<div id="logo">
			<img src="Images/logo.png" alt="Medlink" />
		</div>
		<!--Formulaire de connexion-->
		<form method="POST" action="">
		<div class="container">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item mx-0 mx-lg-1">
             <input class="form-control" name="connexionemail" id="connexionemail" type="email" placeholder="Adresse mail">
            </li>
            <li class="nav-item mx-0 mx-lg-1">
              <input class="form-control" name="connexionmdp" id="connexionmdp" type="password" placeholder="Mot de passe">
            </li>
            <li class="nav-item mx-0 mx-lg-1">
             <button type="submit" name="connect" id="connect" class="btn btn-secondary ">Se connecter
			</button>
            </li>
          </ul>
        </div>
		</form>

		<!--Bouton Menu pour petit écran-->
		<button class="navbar-toggler navbar-toggler-right text-uppercase bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			Menu
		</button>
		<!--Barre de naviguation-->
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item mx-0 mx-lg-1">
              <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#inscrire">S'inscrire</a>
            </li>
            <li class="nav-item mx-0 mx-lg-1">
              <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">About</a>
            </li>
            <li class="nav-item mx-0 mx-lg-1">
              <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
      <!-- Header -->
    <header class="masthead bg-primary text-white text-center">
      <div class="container">
        <h1 class="text-uppercase mb-0">DocLink</h1>
        <hr class="barre-light">
        <h2 class="font-weight-light mb-0">Dossier Médical - Résulats d'analyses - Prise de rendez vous</h2>
      </div>
    </header>

   <!-- S'inscrire -->
   <section id="inscrire">
	<div class="container">
		<h2 class="text-center text-uppercase text-secondary mb-0">S'inscrire</h2>
		<hr class="barre-dark mb-5">
		<div class="row">
		<div class="col-lg-8 mx-auto">
		<?php
			if(isset($_POST['connect']))
			{
				echo "coucou";
			}
			if(isset($erreur_ins))
			{
				echo $erreur_ins;
			}
		?>
			<form name="inscription" id="inscriptionForm" method="POST" action="">
				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Nom</label>
                  <input class="form-control" name="nom" id="nom" type="text" placeholder="Nom" >
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Prénom</label>
                  <input class="form-control" name="prenom" id="prenom" type="text" placeholder="Prénom">
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
               <label></label>
			   <br>
					<select class="form-control" name="sexe" id="sexe">
						<option class="form-control" label="Choisissez votre sexe"></option>
						<option class="form-control" value="Homme">Homme</option>
						<option class="form-control" value="Femme">Femme</option>
					</select>
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Date de naissance</label>
                  <input class="form-control" name="date" id="date" type="date">
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<div class="control-group">
                <div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Adresse mail</label>
                  <input class="form-control" name="email" id="email" type="email" placeholder="Adresse mail">
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Mot de passe</label>
                  <input class="form-control" name="mdp" id="mdp" type="password" placeholder="Mot de passe">
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Confirmez votre mot de passe</label>
                  <input class="form-control" name="conf_mdp" id="inscriptionPassword" type="password" placeholder="Confirmez votre mot de passe">
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<div class="control-group">
				<div class="form-group floating-label-form-group controls mb-0 pb-2">
					<label></label>
					<br>
					<select class="form-control" name="statut" id="statut">
						<option class="form-control" label="Choisissez votre catégorie"></option>
						<option class="form-control" value="Docteur">Docteur</option>
						<option class="form-control" value="Patient">Patient</option>
					</select>
                  <p class="help-block text-danger"></p>
                </div>
				</div>
				<br>
				<div id="success"></div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-xl" name="sendinscriptionButton" id="sendinscriptionButton">S'inscrire</button>
				</div>
            </form>
			<?php
			if (isset($erreur_ins))
			{
				echo $erreur_ins;
			}
		?>
        </div>
        </div>
    </div>
   </section>
    <!-- About -->
    <section class="bg-primary text-white mb-0" id="about">
      <div class="container">
        <h2 class="text-center text-uppercase text-white">Qui sommes nous ?</h2>
        <hr class="barre-light mb-5">
        <div class="row">
          <div class="col-lg-4 ml-auto">
            <p class="lead">DocLink est un service en ligne développé pour les patients et les médecins. Cette plateforme permet de mettre en relations médecins et patients pour pouvoir partager vos résultats et vos analyses.</p>
          </div>
          <div class="col-lg-4 mr-auto">
            <p class="lead">DocLink permet également de prendre rendez-vous avec votre médecin ou spécialiste. Votre dossier est ainsi directement envoyé au médecin.</p>
          </div>
		  <div class="text-center col-lg-8 mx-auto">
            <p class="lead">DocLink est sécurisé et fiable. Aucune de vos données personnelles ne sont conservées ou utilisés par nos soins.</p>
          </div>
        </div>
      </div>
    </section>
    <!-- Contact  -->
    <section id="contact">
      <div class="container">
        <h2 class="text-center text-uppercase text-secondary mb-0">Contactez-nous</h2>
        <hr class="barre-dark mb-5">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
            <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
            <form name="sentMessage" id="contactForm">
              <div class="control-group">
                <div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Nom</label>
                  <input class="form-control" id="name" type="text" placeholder="Nom">
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="control-group">
                <div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Adresse Mail</label>
                  <input class="form-control" id="email" type="email" placeholder="Adresse Mail">
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="control-group">
                <div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Numéro de téléphone</label>
                  <input class="form-control" id="phone" type="tel" placeholder="Numéro de téléphone">
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="control-group">
                <div class="form-group floating-label-form-group controls mb-0 pb-2">
                  <label>Message</label>
                  <textarea class="form-control" id="message" rows="5" placeholder="Message"></textarea>
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <br>
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-xl" id="sendMessageButton">Envoyer</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- Footer -->
    <footer class="footer text-center">
      <div class="container">
        <div class="row">
          <div class="col-md-4 mb-5 mb-lg-0 ml-auto mr-auto">
            <h4 class="text-uppercase mb-4 ">Localisation</h4>
            <p class="lead mb-0">ECE PARIS
              <br>38 Quai de Grenelle <br>75015 Paris</p>
          </div>
          <div class="col-md-4 mb-5 mb-lg-0 mr-auto ml-auto">
            <h4 class="text-uppercase mb-4">Retrouvez nous sur les réseaux !</h4>
            <ul class="list-inline mb-0">
              <li class="list-inline-item">
                <a class="btn btn-outline-light btn-social text-center rounded-circle" href="#">
                  <i class="fa fa-fw fa-facebook"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a class="btn btn-outline-light btn-social text-center rounded-circle" href="#">
                  <i class="fa fa-fw fa-google-plus"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a class="btn btn-outline-light btn-social text-center rounded-circle" href="#">
                  <i class="fa fa-fw fa-twitter"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a class="btn btn-outline-light btn-social text-center rounded-circle" href="#">
                  <i class="fa fa-fw fa-linkedin"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a class="btn btn-outline-light btn-social text-center rounded-circle" href="#">
                  <i class="fa fa-fw fa-dribbble"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <div class="copyright py-4 text-center text-white">
      <div class="container">
        <small>Copyright &copy; DocLink</small>
      </div>
    </div>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-to-top d-lg-none position-fixed ">
      <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
        <i class="fa fa-chevron-up"></i>
      </a>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="bootstrap/vendor/jquery/jquery.min.js"></script>
    <script src="bootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="bootstrap/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="bootstrap/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>



    <!-- Custom scripts for this template -->
    <script src="bootstrap/js/freelancer.min.js"></script>
  </body>

</html>

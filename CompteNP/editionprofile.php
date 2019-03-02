<?php
session_start();

$bdd = new PDO('mysql:host=mysql-pierreyann.alwaysdata.net;dbname=pierreyann_clubepsiwis;charset=utf8', '174118', 'PierreYann', array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION));

if(isset($_SESSION['idetu'])) {
   $requser = $bdd->prepare("SELECT * FROM etudiant WHERE idetu = ?");
   $requser->execute(array($_SESSION['idetu']));
   $user = $requser->fetch();
   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
      $newpseudo = htmlspecialchars($_POST['newpseudo']);
      $insertpseudo = $bdd->prepare("UPDATE etudiant SET pseudo = ? WHERE idetu = ?");
      $insertpseudo->execute(array($newpseudo, $_SESSION['idetu']));
      if ($pseudoerror == 0) {     header('Location: profil.php?idetu='.$_SESSION['idetu']);

   }
   if(isset($_POST['newnom']) AND !empty($_POST['newnom']) AND $_POST['newnom'] != $user['nom']) {
      $newnom = htmlspecialchars($_POST['newnom']);
      $insertnom = $bdd->prepare("UPDATE etudiant SET nom = ? WHERE idetu = ?");
      $insertnom->execute(array($newnom, $_SESSION['idetu']));
   }
   if(isset($_POST['newprenom']) AND !empty($_POST['newprenom']) AND $_POST['newprenom'] != $user['prenom']) {
      $newprenom = htmlspecialchars($_POST['newprenom']);
      $insertprenom = $bdd->prepare("UPDATE etudiant SET prenom = ? WHERE idetu = ?");
      $insertprenom->execute(array($newprenom, $_SESSION['idetu']));

   }
   if(isset($_POST['newage']) AND !empty($_POST['newage']) AND $_POST['newage'] != $user['age']) {
      $newage = htmlspecialchars($_POST['newage']);
      $insertage = $bdd->prepare("UPDATE etudiant SET datenaiss = ? WHERE idetu = ?");
      $insertage->execute(array($newage, $_SESSION['idetu']));
   }

   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
     if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      $newmail = htmlspecialchars($_POST['newmail']);
      $insertmail = $bdd->prepare("UPDATE etudiant SET mail = ? WHERE idetu = ?");
      $insertmail->execute(array($newmail, $_SESSION['idetu']));
      if ($mailerror == 0) {    header('Location: profil.php?idetu='.$_SESSION['idetu']);
   }
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = sha1($_POST['newmdp1']);
      $mdp2 = sha1($_POST['newmdp2']);
      if($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE etudiant SET motdepasse = ? WHERE idetu = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['idetu']));
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
      }
    }else {
       $mailerror = "Cette adresse mail est déjà utilisé";
     }
   }else {
    $pseudoerror = "Ce pseudo est déjà utilisé";
  }
}
}
}

?>
<html>
<head>
   <meta charset="utf-8">
   <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="logo"><a href="#"><img src="logo.png" alt=""></a>
  </div>
  <nav>
    <b>
    <ul>
      <li><a href="index.php" style="text-decoration: none">Accueil</a></li>
      <li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">Les clubs</a>
          <div class="dropdown-content">
            <a href="creation.php">Création</a>
            <a href="adhesion.php">Rejoindre</a>
          </div>
      <li><a href="evenements.php" style="text-decoration: none">Evènements</a></li>
      <li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">Mon profil</a>
          <div class="dropdown-content">
            <a href="profil.php?idetu=<?php echo $_SESSION['idetu'];?>">Voir</a>
            <a href="editionprofile.php">Editer</a>
          </div>
      <li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">Connexion</a>
          <div class="dropdown-content">
            <a href="inscription.php">S'inscrire</a>
            <a href="connexion.php">Se connecter</a>
            <a href="deconnexion.php">Se déconnecter</a>
          </div>
      </li>
    </ul>
    </b>
  </nav>
<div class="formulaire_editionprofile">
  <div align="center">
     <h2>Edition de mon profil</h2>
     <div align="left">
        <form method="POST" action="" enctype="multipart/form-data">
           <label>Pseudo :</label>
           <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" /><br /><br />
           <label>Nom :</label>
           <input type="text" name="newnom" placeholder="Nom" value="<?php echo $user['nom']; ?>" /><br /><br />
           <label>Prenom :</label>
           <input type="text" name="newprenom" placeholder="Prenom" value="<?php echo $user['prenom']; ?>" /><br /><br />
           <label>Age :</label>
           <input type="text" name="newage" placeholder="Age" value="<?php echo $user['age']; ?>" /><br /><br />
           <label>Mail :</label>
           <input type="text" name="newmail" placeholder="Mail" value="<?php echo $user['mail']; ?>" /><br /><br />
           <label>Mot de passe :</label>
           <input type="password" name="newmdp1" placeholder="Mot de passe"/><br /><br />
           <label>Confirmation - mot de passe :</label>
           <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /><br /><br />
           <input type="submit" value="Mettre à jour mon profil !" />
        </form>
        </div>
  </div>
</div>
   </body>
</html>

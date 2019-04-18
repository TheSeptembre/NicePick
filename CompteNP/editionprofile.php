idjoueur<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=projet_open;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION));

if(isset($_SESSION['idjoueur'])) {
   $requser = $bdd->prepare("SELECT * FROM joueur WHERE idjoueur = ?");
   $requser->execute(array($_SESSION['idjoueur']));
   $user = $requser->fetch();
   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
      $newpseudo = htmlspecialchars($_POST['newpseudo']);
      $insertpseudo = $bdd->prepare("UPDATE joueur SET pseudo = ? WHERE idjoueur = ?");
      $insertpseudo->execute(array($newpseudo, $_SESSION['idjoueur']));
      if ($pseudoerror == 0) {     header('Location: profil.php?idjoueur='.$_SESSION['idjoueur']);

   }
   if(isset($_POST['newposte']) AND !empty($_POST['newposte']) AND $_POST['newposte'] != $user['poste']) {
      $newposte = htmlspecialchars($_POST['newposte']);
      $insertposteposte = $bdd->prepare("UPDATE joueur SET poste = ? WHERE idjoueur = ?");
      $insertposte->execute(array($newposte, $_SESSION['idjoueur']));

   }
   if(isset($_POST['newrang']) AND !empty($_POST['newrang']) AND $_POST['newrang'] != $user['rang']) {
      $newrang = htmlspecialchars($_POST['newrang']);
      $insertrang = $bdd->prepare("UPDATE joueur SET datenaiss = ? WHERE idjoueur = ?");
      $insertrang->execute(array($newrang, $_SESSION['idjoueur']));
   }

   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
     if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      $newmail = htmlspecialchars($_POST['newmail']);
      $insertmail = $bdd->prepare("UPDATE joueur SET mail = ? WHERE idjoueur = ?");
      $insertmail->execute(array($newmail, $_SESSION['idjoueur']));
      if ($mailerror == 0) {    header('Location: profil.php?idjoueur='.$_SESSION['idjoueur']);
   }
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = sha1($_POST['newmdp1']);
      $mdp2 = sha1($_POST['newmdp2']);
      if($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE joueur SET motdepasse = ? WHERE idjoueur = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['idjoueur']));
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
}joueur

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
            <a href="profil.php?idjoueur=<?php echo $_SESSION['idjoueur'];?>">Voir</a>
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
           <label>Poste :</label>
           <input type="text" name="newposte" placeholder="poste" value="<?php echo $user['poste']; ?>" /><br /><br />
           <label>Rang :</label>
           <input type="text" name="newrang" placeholder="rang" value="<?php echo $user['rang']; ?>" /><br /><br />
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

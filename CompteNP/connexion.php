<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=projet_open;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION));

if(isset($_POST['formconnexion'])) {
   $pseudoconnect = ($_POST['pseudoconnect']);
   $mdpconnect =($_POST['mdpconnect']);
   if(!empty($pseudoconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM etudiant WHERE pseudo = ? ");
      $requser->execute(array($pseudoconnect));
      $userinfo = $requser->fetch();
      if($userinfo)  {
        $mdpverif = password_verify($mdpconnect,$userinfo['motdepasse']);
         if($mdpverif ){
         $_SESSION['idetu'] = $userinfo['idetu'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['motdepasse'] = $userinfo['motdepasse'];
       header("Location: profil.php?idetu=".$_SESSION['idetu']);
          }else{
          $erreur = "Pseudo ou mot de passe incorrecte !";
          }
      } else {
         $erreur = "Pseudo ou mot de passe incorrecte !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}

?>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <title>Clubs EPSI Lyon</title>
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
<div class="formulaire_connexion">
    <div class="title_connexion">
      <h2>Connexion</h2>
      </div>
      <br /><br />
  <form method="post" action="connexion.php">
           <input type="text" name="pseudoconnect" placeholder="Pseudo" />
           <input type="password" name="mdpconnect" placeholder="Mot de passe" />
           <br /><br />
           <input type="submit" name="formconnexion" value="Se connecter !" />
</form>
<div class="erreur">
  <?php
  if(isset($erreur)) {
  echo '<font color="red">'.$erreur."</font>";
  }
  ?>
</div>
</div>
</body>
</html>

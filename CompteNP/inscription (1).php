<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=projet_open;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION));

if(isset($_POST['inscrit'])) {
$pseudo = ($_POST['pseudo']);
$rang = ($_POST['rang']);
$poste = ($_POST['poste']);
$mdp = ($_POST['mdp']);
$mdp2 = ($_POST['mdp2']);
$mail = ($_POST['mail']);
$mail2 = ($_POST['mail2']);
   if(!empty($_POST['nom']) AND !empty($_POST['rang']) AND !empty($_POST['poste']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']) AND !empty($_POST['mail']) AND !empty($_POST['mail2'])
   AND !empty($_POST['pseudo'])) {
      $pseudolength = strlen($pseudo);
      if($pseudolength <= 255) {
         if($mail == $mail2) {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM joueur WHERE mail = ?");
               $reqmail->execute(array($mail));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
                 $reqpseudo = $bdd->prepare("SELECT * FROM joueur WHERE pseudo = ?");
                 $reqpseudo->execute(array($pseudo));
                 $pseudoexist = $reqpseudo->rowCount();
                 if($pseudoexist == 0) {
                    if($mdp == $mdp2) {
                      $mdp = password_hash($_POST['mdp'],PASSWORD_DEFAULT);
                       $insertjoueur = $bdd->prepare("INSERT INTO joueur(pseudo, rang, poste, mail, motdepasse) VALUES(?, ?, ?, ?, ?, ?)");
                       $insertjoueur->execute(array($pseudo, $rang, $poste, $mail, $mdp ));
                       $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                      } else {
                         $erreur = "Vos mots de passes ne correspondent pas !";
                    }
                  } else {
                      $erreur = "Ce pseudo est déjà utilisé!";
                    }
                 } else {
                    $erreur = "Adresse mail déjà utilisée !";
                 }
              } else {
                 $erreur = "Votre adresse mail n'est pas valide !";
              }
           } else {
              $erreur = "Vos adresses mail ne correspondent pas !";
           }
        } else {
           $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
        }
     } else {
        $erreur = "Tous les champs doivent être complétés !";
     }
}
?>
<html>
<head>
  <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <title>Nice Pick</title>
  <style type="text/css">
    td.alignDroite
      {
        text-align:right;
      }
  </style>
  </head>
  <body>
  <div class="logo"><a href="#"><img src="logo.png" alt=""></a>
  </div>
  <nav>
    <b>
    <ul>
      <li><a href="index.php" style="text-decoration: none">Accueil</a></li>
      <li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">NicePick</a>
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
  <div class="formulaire_inscription">
<form method="post" action="inscription.php">
  <table>
    <tr>
    <td align="right">
   <label for="pseudo">Pseudo :</label>
    </td>
    <td>
   <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
    </td>
   </tr>
    <tr>
    <td align="right">
    <label for="rang">rang :</label>
    </td>
    <td>
       <input type="text" placeholder="Bronze1, Gold3, Diamand2...." id="rang" name="rang" value="<?php if(isset($rang)) { echo $rang; } ?>" />
    </td>
 </tr>
<tr>
    <td align="right">
    <label for="poste">poste :</label>
  </td>
  <td><input type="text" placeholder="Mid, adc, top,..." id="poste" name="poste"></td>
</tr>poste
 <tr>
    <td align="right">
    <label for="mail">Mail :</label>
    </td>
    <td>
       <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
    </td>
 </tr>
 <tr>
    <td align="right">
    <label for="mail2">Confirmation du mail :</label>
    </td>
    <td>
       <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
    </td>
 </tr>
 <tr>
    <td align="right">
    <label for="mdp">Mot de passe :</label>
    </td>
    <td>
       <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
    </td>
 </tr>
 <tr>
    <td align="right">
    <label for="mdp2">Confirmation du mot de passe :</label>
    </td>
    <td>
       <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
    </td>
 </tr>
 <tr>
    <td align="left">

       <td><input type="submit" name="inscrit" value="Je m'inscris"></td>
       <td><input type="reset" name="Effacer" value="Annuler"></td>
 </tr>
</table>
</form>
<?php
if(isset($erreur)) {
echo '<font color="red">'.$erreur."</font>";
}
?>
</div>
</body>
</html>

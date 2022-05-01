<?php
// d´efinition des param`etres de connexion `a la base de donn´ees
$config_base['hote'] = "dbserver";
$config_base['utilisateur'] = "anguyen006";
$config_base['motdepasse'] = "@boule";
$config_base['nom_base'] = "anguyen006";
// connexion `a la base de donn´ees
try
{
$pdo = new PDO( "mysql:host={$config_base['hote']};
dbname={$config_base['nom_base']}",
"{$config_base['utilisateur']}",
"{$config_base['motdepasse']}");
// afficher les messages d'erreurs pour trouver les erreurs
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
// jeu de caract`eres : UTF-8
$pdo->query("SET NAMES utf8");
$pdo->query("SET CHARACTER SET utf8");
}
catch (PDOException $exception)
{
echo "Connexion ´echou´ee : " . $exception->getMessage();
}
$sum=0;

if (isset($_POST['sum+'])){
  $sum=$_POST['sum+'];
}
if (isset($_POST['sum-'])){
  $sum=$_POST['sum-']*(-1);
}

if ($sum!=0) {
  $requete="INSERT INTO depenses (somme,date_depense) VALUES (?,NOW())";
  $reponse=$pdo->prepare($requete);
  $reponse->execute(array($sum));
}

if (isset($_POST['suppr'])) {
  $pdo->prepare("DELETE FROM depenses ;")->execute(array());
}

if (isset($_POST['this_sum']) and isset($_POST['date'])) {
  $pdo->prepare("DELETE FROM depenses WHERE somme=? AND date_depense=?;")->execute(array($_POST['this_sum'] , $_POST['date']));
}
header('Location: depenses.php');
 ?>

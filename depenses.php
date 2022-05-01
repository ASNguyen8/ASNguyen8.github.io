<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Expencies</title>
    <style>
      .container div{
        float : left;
        width:50%;
      }

      table{
        width:70%;
      }

      table,td{
        border: 1px solid black;
      }
    </style>
  </head>
  <body>
    <div class="container">

    <div>
    <h1>Calcule tes dépenses :</h1>
    <br>
    <br>
    <table>
      <tr>
        <td> <h3>~Gains~</h3> </td>
        <td> <h3>~Dépenses~</h3> </td>
      </tr>
      <tr>
        <td>
          <form action="enr.php" method="post">
            <input type="number" name="sum+" placeholder="0" step="0.01">
            <br>
            <input type="submit" value="Valider">
          </form>
        </td>
        <td>
          <form action="enr.php" method="post">
            <input type="number" name="sum-" placeholder="0" step="0.01">
            <br>
            <input type="submit" value="Valider">
          </form>
        </td>
      </tr>
    </table>
  <br>
  <br>
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


  $rgain="SELECT sum(somme) as g FROM depenses WHERE somme>0;";
  $gains=$pdo->prepare($rgain);
  $gains->execute();
  $dirg = $gains->fetchall();
  $gain = $dirg[0]['g'];

  $rdep="SELECT sum(somme) as d FROM depenses WHERE somme<0;";
  $dep=$pdo->prepare($rdep);
  $dep->execute();
  $dird = $dep->fetchall();
  $depense = $dird[0]['d'];

  $bilan=$gain+$depense;
  $p_bilan="";
  if ($gain==0) {
    if ($depense==0) {
      $p_bilan="Rien pour le moment.";
    }else {
      $p_bilan="Tu as seulement dépensé de l'argent pour le moment.";
    }
  }else {
    $p_bilan="Total : ".round( ( ( (0-$depense)*100) /$gain),2 )." % de dépenses";
  }
   ?>
  <h2>Pour le moment ce mois-ci :</h2>
  <table>
    <thead>
      <tr>
              <td>Statistiques</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Entrant</td>
        <td><?php echo $gain; ?> €</td>
      </tr>
      <tr>
        <td>Sortant</td>
        <td><?php echo $depense; ?> €</td>
      </tr>
      <tr>
        <td>Total</td>
        <td><?php echo $bilan; ?> €</td>
      </tr>
    </tbody>
  </table>
  <br>
  <p><?php echo $p_bilan; ?></p>
  <?php $debut_de_mois=908.28;
  $cc=$bilan+$debut_de_mois; ?>
  <p>Current wealth : <b style="color:red;font-size: 36px;"><?php echo round($cc,2)."€"; ?></b></p>
</div>
<div>
  <h1>Finances du mois en cours:</h1>
  <table>
    <thead>
      <tr>
        <td>Identifiant</td>
        <td>Somme</td>
        <td>Date</td>
        <td></td>
      </tr>
    </thead>
    <tbody>
      <?php
        $a="SELECT * FROM `depenses` order by date_depense";
        $ra=$pdo->prepare($a);
        $ra->execute();
        $exp = $ra->fetchall();
        for ($i=0; $i < count($exp); $i++) {
          $sup="<td><form action=\"enr.php\" method=\"post\"><input type=\"hidden\" name=\"this_sum\" value=".$exp[$i]['id']."\"><input type=\"submit\" value=\"Suppr\"></form></td>";
          echo "<tr><td>".$exp[$i]['id']."€</td><td>".$exp[$i]['somme']."€</td><td>".$exp[$i]['date_depense']."</td>".$sup."</tr>";
        }
       ?>
    </tbody>
  </table>
</div>
</div>
<div>
  <a href="depenses.php">Recharger la page</a>
  <br>
  <br>
  <form action="enr.php" method="post">
    <input type="hidden" name="suppr" value="true">
    <input type="submit" value="Clean">
  </form>
</div>
  </body>
</html>

<?php

// on se connecte à MySQL 
$db = mysql_connect('db538611091.db.1and1.com', 'dbo538611091', 'diop2014'); 

// on sélectionne la base 
mysql_select_db('db538611091',$db); 

// on crée la requête SQL 
$sql = 'SELECT nom,prenom,statut,date FROM famille_tbl'; 

// on envoie la requête 
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error()); 

// on fait une boucle qui va faire un tour pour chaque enregistrement 
while($data = mysql_fetch_assoc($req)) 
    { 
    // on affiche les informations de l'enregistrement en cours 
    echo '<b>'.$data['nom'].' '.$data['prenom'].'</b> ('.$data['statut'].')'; 
    echo ' <i>date de naissance : '.$data['date'].'</i><br>'; 
    } 

// on ferme la connexion à mysql 
mysql_close(); 

?>
<?php
$PARAM_hote='db538611091.db.1and1.com'; // le chemin vers le serveur
$PARAM_port='3306';
$PARAM_nom_bd='db538611091'; // le nom de votre base de données
$PARAM_utilisateur='dbo538611091'; // nom d'utilisateur pour se connecter
$PARAM_mot_passe='diop2014'; // mot de passe de l'utilisateur pour se connecter
$connexion = new PDO('mysql:host='.$PARAM_hote.';port='.$PARAM_port.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
?>
<?php
try
{
        $connexion = new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
}
 
catch(Exception $e)
{
        echo 'Une erreur est survenue !';
        die();
}
phpinfo();
?>
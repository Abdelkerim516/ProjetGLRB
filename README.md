Projet Gestion d'un laboratoire de recherche biomedical.

Technologie 

Frontend = html, bootstrap, js, css
backend = php
database = Mysql

### Cours PHP Récap
# 1. Connexion a la BDD avec PDO
PDO est un instance qui permet a PHP de communique avec une BDD.

Pour cela Nous allons avoir besoin de quatre renseignements :

# A. Le nom de l'hôte : c'est l'adresse IP de l'ordinateur où MySQL est installé. Le plus souvent, MySQL est installé sur le même ordinateur que PHP : dans ce cas, mettez la valeur``localhost`` . 

# B. La base : c'est le nom de la base de données à laquelle vous voulez vous connecter.

# C. L'identifiant et le mot de passe : ils permettent de vous identifier.

Expl: 

<?php
$ServerName = "localhost";
$BdName = "Test";
$Identifian = "admin"
$MotPasse = "root";

$con = new PDO('mysql:host=$ServerName;dbname=$BdName;charset=utf8mb4', $Identifian, $MotPasse);
?>

# 2. Ecriture de la requete SQL avec marquers
Definir la requete de facon securiser grace aux marqueres.

$sql = "SELECT * FROM livre WHERE id = :id"

# 3. Preparation de la requete
 Preparer une requete sans l'executer
 
 $stmt = $con->prepare($sql);

 # 4. Liaison des variables aux marquers
 Associer les valeurs PHP aux marquers SQL. Ont a trois Methodes

 # a. bindParam = Lier une variable(Parametre), par reference.

 $id = 1;
 $stmt->bindParam(":id",$id);

 # b. bindValue = Lier une valeur fixe

 $stmt->bindValue(":id",1);

 # c. execute avec tableau Mehtode recommander

 $stmt->execute([
    ":id" => 1
 ]);

 # 5. Exectution de la requete
 Une fois qu'ont a choisir la methode pour lier les variable aux marqueres ont lance(execute) la requete

 $stmt->execute();

 # 6. Recuperation des données

 La methode fetch() = recupere une seule ligne.

 $resultat = $stmt->fetch();

 La methode fetchAll() = recupere toutes les lignes.

 $resultats = $stmt-fetchAll();

# 7. Parcours et affichage des données 

foreach ($resultats as $ligne){
    echo $ligne["nom"];
}

# Securisation du Formulaire

Trim() : est une fonction qui permette d'effacer des espaces;
FITER_VAR() : Elle permete de verifier la validiter d'un email avec le Parametre FILTER_VALIDATE_EMAIL

# a. Session
Sont des moyens permettent de stocke les données des users.
Pour demarrer une session ont utilise la fonction session_start();

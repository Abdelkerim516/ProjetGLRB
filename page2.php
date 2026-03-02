<?php
session_start();
if(isset($_SESSION['iden']) and isset($_SESSION['login']) and isset ($_SESSION['password']))
    {
    echo "Bonjour Mr. \n" .$_SESSION['login']."Votre identifiant est \n" .$_SESSION['iden'];

}
else {
    echo "Erreur Veuiller ressayer";
}
?>
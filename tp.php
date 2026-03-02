<?php
// $str = "Un ptt cafè & des croisant < 3";
// htmlentities($str);
// echo $str;

// $salut = "Hello World!   \n";

// echo trim($salut);
// $email = "abbo@gmail.com";
// if (filter_var($email, FILTER_VALIDATE_EMAIL)){
//     echo "Email est valide :"; 
// }
// else {
//     echo "Email est invalide";
// }
  
session_start(); // demarage de la session
$_SESSION['iden'] = 456;
$_SESSION['login'] = "sup";
$_SESSION['password'] = "sup123"
?>
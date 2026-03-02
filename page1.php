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
$_SESSION['login'] = "Abbo";
$_SESSION['password'] = "sup123";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 1</title>
</head>
<body>

    <a href="/page2.php">Clicker vers la Page 2</a>
</body>
</html>
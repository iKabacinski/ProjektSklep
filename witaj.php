<?php
session_start();

if(!isset($_SESSION['udanarejestracja'])){
    header('Location: index.php');
    exit();

}
else
{
    unset($_SESSION['udanarejestracja']);
}


?>


<!DOCTYPE HTML>
<HTML lang="pl">
<HEAD>
<meta charset ="utf-8"/>
    <link rel="stylesheet" type="text/css" href="sklep.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script></sricpt>

</HEAD>
<body>



<div class=" = menu-design">
    <strong style="font-size:50px;color:black"> Projekt sklep</strong>
</div>
<div class="menu">
    <a href="index.php">Strona główna</a>

    <a href="">Na codzień</a>
    <a href="">Na trening </a>
    <a href="">Akcesoria </a>
    <a href="">Kontakt </a>
    <a href="">Koszyk</a>
    <a href="log.php">Zaloguj się </a>
    <a href="wyloguj.php">Wyloguj się</a>
    <a class="reg" href="rejestracja.php">Zarejestruj się </a>
</div>


    Zostałes zarejestrowany. Możesz sie zalogowac</br></br>


</br><a href="log.php"> Zaloguj  sie na swoje konto</a>
<br></br><br></br>
<
<?php



?>
</body>

</HTML>
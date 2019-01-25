<?php

session_start();
if(isset($_SESSION['KlientID'])){
    echo '<script>alert("Jesteś już zalogowany")</script>';
    echo '<script>window.location="zalogowany.php"</script>';
}
?>

<!DOCTYPE HTML>
<HTML lang="pl">
<HEAD>
    <link rel="stylesheet" type="text/css" href="sklep.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script></sricpt>

    <meta charset ="utf-8"/>
<title> Logowanie do sklepu </title>
</HEAD>
<body>

<div class=" = menu-design">
    <strong style="font-size:50px;color:black"> Projekt sklep</strong>
</div>
<div class="menu">
    <a href="index.php">Strona główna</a>

    <a href="naCodzien.php">Na codzień</a>
    <a href="naTrening.php">Na trening </a>
    <a href="akcesoria.php">Akcesoria </a>
    <a href="">Kontakt </a>
    <a href="koszyk.php">Koszyk</a>
    <a href="log.php">Zaloguj się </a>
    <a class="reg" href="rejestracja.php">Zarejestruj się </a>
</div>
<div class="container">
<h2>Zaloguj sie:</h2> <br/>

<form action="zaloguj.php" method="post" >

Login: </br> <input type="text" name = "login"/><br/>
Haslo: </br> <input type="password" name = "haslo"/><br/><br/>
<input type="submit" value ="Zaloguj sie"/>


</form>
<?php
if(isset($_SESSION['blad'])){
echo $_SESSION['blad'];}
?>
</div>
</body>

</HTML>
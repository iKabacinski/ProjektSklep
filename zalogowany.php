<?php
session_start();
require_once "connect.php";
?>


<!DOCTYPE HTML>
<HTML lang="pl">
<HEAD>
    <link rel="stylesheet" type="text/css" href="sklep.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script></sricpt>

    <meta charset ="utf-8"/>
<title> Sklep online </title>
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
    <a href="wyloguj.php">Wyloguj się</a>

</div>
<div class="container">
<?php
    echo "<h2 align='center'>Witaj !</h2>";
?>

<h2>Twoje dane:</h2>
<?php
   $id=$_SESSION['KlientID'];
$queries ="Select * from kontakt where KlientID = '$id'";
$polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
if($rezultat= $polaczenie->query($queries)){
    $wiersz=$rezultat->fetch_assoc();
    $_SESSION['email'] = $wiersz['email'];
    $_SESSION['nrTelefonu'] = $wiersz['nrTelefonu'];
}

?>

<br/>
Imie: <?php echo $_SESSION['Imie']; ?>
<br/>
Nazwisko: <?php echo $_SESSION['Nazwisko']; ?>
<br/>
login: <?php echo $_SESSION['login']; ?>
<br/>
Adres email: <?php echo $wiersz['email']; ?>
<br/>
Nr telefonu: <?php echo $wiersz['nrTelefonu']; ?>
<div style="clear:both"></div>
<h2>Twój koszyk</h2>



<div class="table-responsive">
    <table class="table-bordered">
        <tr>
            <th width="45%">Nazwa Produktu</th>
            <th width="10%">Ilosc</th>
            <th width="20%">Cena</th>
            <th width="10%">Cena końcowa</th>
            <th width="5%"> Action</th>
        </tr>
        <?php
        if(!empty($_SESSION["cart"])){

            $total=0;
            foreach ($_SESSION["cart"] as $keys => $values){
                ?>

                <tr>
                    <td> <?php echo $values["Nazwa"]; ?></td>
                    <td> <?php echo $values["stan_magazynowy"]; ?></td>
                    <td><?php echo $values["cena_jednostkowa"]; ?> zł</td>
                    <td><?php echo number_format($values["stan_magazynowy"]*$values["cena_jednostkowa"],2);?> zł</td>
                    <td><a href="sklep.php?action=delete&ProduktID=<?php echo $values["ProduktID"]; ?>"><span class="text-danger">X</span></a></td>
                </tr>
                <?php
                $total=$total+($values["stan_magazynowy"] * $values["cena_jednostkowa"]);
            }
            ?>
            <tr>
                <td colspan="3" align="right">Końcowa</td>
                <td align="left"><?php echo number_format($total,2);?> zł</td>
                <td><a href="order.php"<?php echo $values["ProduktID"];?>> <span class="text-info">Zamów</span></td>
            </tr>
            <?php
        }
        ?>


    </table>


</div>
</div>

</div>
</body>

</HTML>
</div>
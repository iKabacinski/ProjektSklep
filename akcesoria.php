<?php
session_start();
require_once "connect.php";

?>


<!DOCTYPE HTML>
<html lang="pl-PL">
<HEAD>
    <meta charset ="utf-8"/>
    <link rel="stylesheet" type="text/css" href="sklep.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script></sricpt>
</HEAD>
<body>

<!--<h1> Zamowienia online</h1>-->

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

    <a class="reg" href="rejestracja.php">Zarejestruj się </a>
</div>

<div class="container" style="width: 60%"
<br><br>
<?php
$connect = new mysqli($host,$db_user,$db_password,$db_name);

$query="select * from produkt where KategoriaID=16 order by ProduktID asc";
$result=mysqli_query($connect,$query);

if(mysqli_num_rows($result)>0){
    while($row=mysqli_fetch_array($result)){
        ?>
        <div class="col-md-3">
            <form method="post" action="sklep.php?action=add&ProduktID=<?php echo $row["ProduktID"]; ?>">
                <div style="border: 1px solid #eaeaec; margin: -1px 19px 3px -1px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); padding:10px;" align="center">
                    <img src="<?php echo $row["image"]; ?>" class="img-responsive">
                    <h5 class="text-info"><?php echo $row["Nazwa"]; ?></h5>
                    <h5 class="text-info">Rozmiar: <?php echo $row["rozmiar"]; ?></h5>
                    <h5 class="text-danger"><?php echo $row["cena_jednostkowa"]; ?> zł</h5>
                    <input type="text" name="quantity" class="form-control" value="1">
                    <input type="hidden" name="hidden_name" value="<?php echo $row["Nazwa"]; ?>">
                    <input type="hidden" name="hidden_price" value="<?php echo $row["cena_jednostkowa"]; ?>">
                    <input type="submit" name="add" style="margin-top:5px;" class="btn-default" value="Dodaj">
                </div>
            </form>
        </div>
        <?php
    }
}

?>

<div style="clear:both"></div>
<h2>Twój koszyk</h2>
<div class="table-responsive">
    <table class="table-bordered">
        <tr>
            <th width="40%">Nazwa Produktu</th>
            <th width="10%">Ilosc</th>
            <th width="20%">Cena</th>
            <th width="15%">Cena końcowa</th>
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
                    <td><a href="sklep.php?action=delete&ProduktID=<?php echo $values["ProduktID"];?>"> <span class="text-danger">X</span></a></td>
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










</body>

</html>
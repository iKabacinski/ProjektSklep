<?php
session_start();
    if(!isset($_SESSION['KlientID'])){
        echo '<script>alert("Nie jesteś zalogowany")</script>';
        echo '<script>window.location="log.php"</script>';
    }
    if(isset($_POST['ulica']))
    {
        //udana walidacja
        $wszystko_ok=true;

        //klientID
        $klientID=$_SESSION['KlientID'];

        //adres
        $ulica = $_POST['ulica'];
        $nrUlicy = $_POST['nrUlicy'];
        $nrDomu = $_POST['nrDomu'];
        $kodPocztowy = $_POST['kodPocztowy'];
        $miasto = $_POST['miasto'];

        $miasto = htmlentities($miasto,ENT_QUOTES,"UTF-8");
        $ulica = htmlentities($ulica,ENT_QUOTES,"UTF-8");



        if(ctype_alnum($miasto)==false){
            $wszystko_ok=false;
            $_SESSION['e_miasto']="Podaj prawdziwą nazwe miasta. Tylko znaki alfanumeryczne";

        }

        if(ctype_alnum($ulica)==false){
            $wszystko_ok=false;
            $_SESSION['e_ulica']="Podaj prawdziwą nazwe ulicy. Tylko znaki alfanumeryczne";

        }



        if(is_numeric($nrUlicy)==false)
        {
            $wszystko_ok = false;
            $_SESSION['e_nrUlicy']="To nie jest numer.";
        }

        if(is_numeric($nrDomu)==false){
            $wszystko_ok = false;
            $_SESSION['e_nrDomu']="To nie jest numer.";
        }
        if(strlen($kodPocztowy)!=5){
            $wszystko_ok = false;
            $_SESSION['e_kodPocztowy']="To nie jest kod pocztowy.";
        }
        if(is_numeric($kodPocztowy)==false){
            $wszystko_ok = false;
            $_SESSION['e_kodPocztowy']="To nie jest kod pocztowy.";
        }

        //potwierdz
        if(!isset($_POST['potwierdz']))
        {
            $wszystko_ok = false;
            $_SESSION['e_potwierdz']= "Potwierdz swoje dane";
        }
        //combobox
        if($_SESSION['przewoznik']='dhlPobranie'){
            $_SESSION['total']=$_SESSION['total']+12;
            $przewoznik = 1;
        }
        else if($_SESSION['przewoznik']='paczkomatyPobranie'){
            $_SESSION['total']=$_SESSION['total']+10;
            $przewoznik = 2;
        }
        else if($_SESSION['przewoznik']='pocztaPobranie'){
            $_SESSION['total']=$_SESSION['total']+10;
            $przewoznik = 6;
        }
        else if($_SESSION['przewoznik']='upsPobranie'){
            $_SESSION['total']=$_SESSION['total']+16;
            $przewoznik = 7;
        }
        else if($_SESSION['przewoznik']='dhlPrzelew'){
            $_SESSION['total']=$_SESSION['total']+8;
            $przewoznik = 8;
        }
        else if($_SESSION['przewoznik']='paczkomatyPrzelew'){
            $_SESSION['total']=$_SESSION['total']+8;
            $przewoznik = 9;
        }
        else if($_SESSION['przewoznik']='pocztaPrzelew'){
            $_SESSION['total']=$_SESSION['total']+8;
            $przewoznik = 10;
        }
        else if($_SESSION['przewoznik']='upsPrzelew'){
            $_SESSION['total']=$_SESSION['total']+14;
            $przewoznik = 11;
        }

        $total=$_SESSION['total'];
        $status= 'Zaakceptowano';



        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        $current_date=date('Y-m-d');
        try{
            $polaczenie = new mysqli($host,$db_user,$db_password,$db_name);

            if($polaczenie->connect_errno!=0){

                throw new Exception(mysqli_connect_errno());
                }

                else {
                    if($wszystko_ok ==true){

                        $queries ="
                        INSERT INTO adres(AdresID,KlientID,kodPocztowy,Miasto,nrUlicy,nrDomu,ulica) values(NULL,'$klientID','$kodPocztowy','$miasto','$nrUlicy','$nrDomu','$ulica');
                        INSERT INTO zamowienie1(zamowienieID,KlientID,koszt,status_zamowienia,przewoznikID,AdresID) values(NULL,'$klientID','$total','$status','$przewoznik',NULL);
                        
                        UPDATE zamowienie1 set AdresID=(Select AdresID from adres where KlientID = '$klientID') where KlientID = '$klientID';
                        ";
                        if($rezultat= $polaczenie->multi_query($queries)){

                            echo '<script>alert("Złożono zamówienie")</script>';
                            echo '<script>window.location="index.php"</script>';
                            //$rezultat= mysqli_free_result();
                        }

                        else{
                            throw new Exception($polaczenie->error);
                        }

                    }
                }

                    $polaczenie->close();
                }

        catch(Exception $e){
            echo '<span style = "color:red;">BŁĄD SERWERA TERAZ NIE DZIALA</span>';
            echo '<br/> "Informacja developerska"'.$e;
        }

        if($wszystko_ok ==true)
        {


            //tworzymy zamowienie
            //echo"zlozono zamowienie";exit();
        }

    }


?>



<!DOCTYPE HTML>
<html lang="pl">
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



<div style="clear:both"></div>
<h2>Twój koszyk</h2>
<div class="table-responsive">
    <table class="table-bordered">
        <tr>
            <th width="40%">Nazwa Produktu</th>
            <th width="10%">Ilosc</th>
            <th width="20%">Cena jednostkowa</th>
            <th width="15%">Cena</th>
            <th width="5%"> Action</th>
        </tr>

        <?php
        if(!empty($_SESSION["cart"])){

            $_SESSION['total']=0;
            foreach ($_SESSION["cart"] as $keys => $values){
                ?>

                <tr>
                    <td> <?php echo $values["Nazwa"]; ?></td>
                    <td> <?php echo $values["stan_magazynowy"]; ?></td>
                    <td><?php echo $values["cena_jednostkowa"]; ?> zł</td>
                    <td><?php echo number_format($values["stan_magazynowy"]*$values["cena_jednostkowa"],2);?> zł</td>
                    <td><a href="sklep.php?action=delete&ProduktID=<?php echo $values["ProduktID"];?>"> <span class="text-danger">X</span></a></td>
                </tr>
                <input type="hidden" name="nazwa" value="<?php echo $values["Nazwa"]; ?>">
                <input type="hidden" name="cena_jednostkowa" value="<?php echo $values["cena_jednostkowa"]; ?>">
                <input type="hidden" name="ilosc" value="<?php echo $values["stan_magazynowy"]; ?>">
                <input type="hidden" name="produktID" value="<?php echo $values["ProduktID"]; ?>">


                <?php
                $_SESSION['total']=$_SESSION['total']+($values["stan_magazynowy"] * $values["cena_jednostkowa"]);
            }
            ?>

            <input type="hidden" name="total" value="<?php echo number_format( $_SESSION['total'],2) ?>">
            <tr>
                <td colspan="3" align="right">Końcowa</td>
                <td align="right"><?php echo number_format($_SESSION['total'],2);?> zł</td>
                <td></td>
            </tr>
            <?php
        }
        ?>
    </table>

    </br> <h2>Złóż zamówienie</h2>
    <form method = "post">
        Ulica: <br/> <input type="text" name="ulica"/><br/>

        <?php

        if(isset($_SESSION['e_ulica'])){
            echo'<div class = "error">'.$_SESSION['e_ulica'].'</div>';
            unset($_SESSION['e_ulica']);
        }
        ?>
        Nr ulicy: <br/> <input type="text" name="nrUlicy"/><br/>
        <?php

        if(isset($_SESSION['e_nrUlicy'])){
            echo'<div class = "error">'.$_SESSION['e_nrUlicy'].'</div>';
            unset($_SESSION['e_nrUlicy']);
        }
        ?>

        Nr domu: <br/> <input type="text" name="nrDomu"/><br/>
        <?php

        if(isset($_SESSION['e_nrDomu'])){
            echo'<div class = "error">'.$_SESSION['e_nrDomu'].'</div>';
            unset($_SESSION['e_nrDomu']);
        }
        ?>

        Kod pocztowy: <br/> <input type="text" name="kodPocztowy"/><br/>

        <?php

        if(isset($_SESSION['e_kodPocztowy'])){
            echo'<div class = "error">'.$_SESSION['e_kodPocztowy'].'</div>';
            unset($_SESSION['e_kodPocztowy']);
        }
        ?>
        Miasto: <br/> <input type="text" name="miasto"/><br/>
        <?php
        if(isset($_SESSION['e_miasto'])){
            echo'<div class = "error">'.$_SESSION['e_miasto'].'</div>';
            unset($_SESSION['e_miasto']);
        }
        ?>
        <br/>
        <select name="przewoznik">
            <option value="dhlPobranie">DHL Pobranie 12 zł</option>
            <option value="paczkomaryPobranie">Paczkomaty Pobranie 10 zł</option>
            <option value="pocztaPobranie">Poczta Pobranie 10 zł</option>
            <option value="upsPobranie">UPS Pobranie 16 zł</option>

            <option value="dhlPrzelew">DHL Przelew 10 </option>
            <option value="paczkomaryPrzelew">Paczkomaty Przelew 8</option>
            <option value="pocztaPrzelew">Poczta Przelew 8</option>
            <option value="upsPrzelew">UPS Pobranie 14</option>
        </select>

        <br/>
        <label>
            <input type="checkbox" name = "potwierdz"/> Potwierdzam dane
        </label>
        <?php

        if(isset($_SESSION['e_potwierdz'])){
            echo'<div class = "error">'.$_SESSION['e_potwierdz'].'</div>';
            unset($_SESSION['e_potwierdz']);
        }
        ?>


        <br/>

        <input type= "submit" value="Złóż zamowienie">


    </form>



    </div>










</body>

</html>
<?php
    session_start();
if(isset($_SESSION['KlientID'])){
    echo '<script>alert("Najpierw się wyloguj")</script>';
    echo '<script>window.location="index.php"</script>';
}
    if(isset($_POST['email']))
    {
        //udana walidacja
        $wszystko_ok=true;

        //login
        $login = $_POST['login'];
        //imie i nazwisko
    
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];

        $login = htmlentities($login,ENT_QUOTES,"UTF-8");
        $imie = htmlentities($imie,ENT_QUOTES,"UTF-8");
        $nazwisko = htmlentities($nazwisko,ENT_QUOTES,"UTG-8");

        //dlugosc logina 
        if((strlen($login)<3)||(strlen($login)>20))
        {
            $wszystko_ok = false;
            $_SESSION['e_login']="Login musi posiadać od 3 do 20 znaków";
        }

        if(ctype_alnum($login)==false){
            $wszystko_ok=false;
            $_SESSION['e_login']="Login może składać sie tylko ze znakow alfanumerycznych(bez polskich znaków).";

        }

        //mail
        $email = $_POST['email'];
        $emailB = filter_var($email,FILTER_SANITIZE_EMAIL);

        if(filter_var($emailB,FILTER_VALIDATE_EMAIL)==false||($emailB!=$email))
        {
            $wszystko_ok = false;
            $_SESSION['e_email']="Podaj poprawny adres email.";
        }
        //hasla
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];

        if((strlen($haslo1)<8)||(strlen($haslo1)>20))
        {
            $wszystko_ok = false;
            $_SESSION['e_haslo']="Haslo musi posiadać od 8 do 20 znakow."; 
        }

        if($haslo1 != $haslo2){
            $wszystko_ok = false;
            $_SESSION['e_haslo']="Podane hasla nie sa idenyczne."; 
        }

        //chechbox
        if(!isset($_POST['regulamin']))
        {
            $wszystko_ok = false;
            $_SESSION['e_regulamin']= "Zaakceptuj regulamin";
        }

        $haslo_hash = password_hash($haslo1,PASSWORD_DEFAULT);




        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        

        try{
            $polaczenie = new mysqli($host,$db_user,$db_password,$db_name);

            if($polaczenie->connect_errno!=0){
		
                throw new Exception(mysqli_connect_errno());
                }

                else {
                    //czy login juz istnieje
                    $rezultat = $polaczenie->query("SELECT KlientID from klient where login = '$login'");

                    if(!$rezultat) throw new Exception($polaczenie->error);

                    $ile_loginow = $rezultat->num_rows;

                    if($ile_loginow>0){
                        $wszystko_ok = false;
                        $_SESSION['e_login']="Podany login już istnieje";
                    }

                    //czy mail juz istnieje
                    $rezultat = $polaczenie->query("SELECT KontaktID from kontakt where email = '$email'");

                    if(!$rezultat) throw new Exception($polaczenie->error);

                    $ile_maili = $rezultat->num_rows;

                    if($ile_maili>0){
                        $wszystko_ok = false;
                        $_SESSION['e_email']="Podany email już istnieje";
                    }
                    //nrTelefon
                    $nrTelefon = $_POST['nrTelefon'];

                    if(strlen($nrTelefon)>9 && strlen($nrTelefon)<9){
                        $wszystko_ok = false;
                        $_SESSION['e_nrTelefonu']="Podaj poprawny numer telefonu";

                    }
                    if(!is_numeric($nrTelefon)){

                        $wszystko_ok = false;
                        $_SESSION['e_nrTelefonu']="Podaj poprawny numer telefonu";

                    }




                    if($wszystko_ok ==true){
                        $queries ="
                        INSERT INTO klient(KlientID,Imie,Nazwisko,login,haslo) VALUES(NULL,'$imie','$nazwisko','$login','$haslo_hash');
                        INSERT INTO kontakt(KontaktID,KlientID,nrTelefonu,email) VALUES(NULL, null,'$nrTelefon','$email');
                        UPDATE kontakt set KlientID=(Select KlientID from klient where login = '$login') where email = '$email';
                        ";
                        if($rezultat= $polaczenie->multi_query($queries)){
                        

                            $_SESSION['udanarejestracja']=true;
                            header('Location:witaj.php');
                          
                            //$rezultat= free_result();
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
            //tworzymy konto
            echo"UDANA WALIDACJA";exit();
        }

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

    <a href="naCodzien.php">Na codzień</a>
    <a href="naTrening.php">Na trening </a>
    <a href="akcesoria.php">Akcesoria </a>
    <a href="">Kontakt </a>
    <a href="koszyk.php">Koszyk</a>
    <a href="log.php">Zaloguj się </a>
    <a class="reg" href="rejestracja.php">Zarejestruj się </a>
</div>


<div class="container">
</br> <h2>Załóż konto</h2> 

    <form method = "post">
    Login: <br/> <input type="text" name="login"/><br/>

    <?php

    if(isset($_SESSION['e_login'])){
        echo'<div class = "error">'.$_SESSION['e_login'].'</div>';
        unset($_SESSION['e_login']);
    }
    ?>
    Imie: <br/> <input type="text" name="imie"/><br/>

    Nazwisko: <br/> <input type="text" name="nazwisko"/><br/>

    E-mail: <br/> <input type="text" name="email"/><br/>

    <?php

    if(isset($_SESSION['e_email'])){
    echo'<div class = "error">'.$_SESSION['e_email'].'</div>';
    unset($_SESSION['e_email']);
        }
    ?>
      Nr telefonu: <br/> <input type="text" name="nrTelefon"/><br/>
        <?php
        if(isset($_SESSION['e_nrTelefon'])){
        echo'<div class = "error">'.$_SESSION['e_nrTelefon'].'</div>';
        unset($_SESSION['e_nrTelefon']);
        }
        ?>

    Twoje hasło: <br/> <input type="password" name="haslo1"/><br/>
    <?php

    if(isset($_SESSION['e_haslo'])){
    echo'<div class = "error">'.$_SESSION['e_haslo'].'</div>';
    unset($_SESSION['e_haslo']);
    }
    ?>

    Powtorz hasło : <br/> <input type="password" name="haslo2"/><br/>
    <label>
        <input type="checkbox" name = "regulamin"/> Akceptuje regulamin
    </label>
    <?php

    if(isset($_SESSION['e_regulamin'])){
    echo'<div class = "error">'.$_SESSION['e_regulamin'].'</div>';
    unset($_SESSION['e_regulamin']);
    }
    ?>


    <br/>

    <input type= "submit" value="Utwórz konto">


    </form>
</div>
</body>

</HTML>
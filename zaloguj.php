<?php

session_start();
require_once "connect.php";
	
	$polaczenie= @new mysqli($host,$db_user,$db_password,$db_name);
	if($polaczenie->connect_errno!=0){
		
		echo "ERROR".$polaczenie->connect_errno;
		}
	
	else
	{	
	$login =$_POST['login'];
	$haslo =$_POST['haslo'];
	$login = htmlentities($login,ENT_QUOTES,"UTF-8");
	
	$haslo = htmlentities($haslo,ENT_QUOTES,"UTF-8");

	if($result = @$polaczenie->query(sprintf("SELECT * FROM klient where login = '%s'",mysqli_real_escape_string($polaczenie,$login)))){

		$ile_klient =$result->num_rows;
				if($ile_klient>0){
					$wiersz=$result->fetch_assoc();
					if(password_verify($haslo,$wiersz['haslo']))
					{
					$_SESSION['login']=$wiersz['login'];
					$_SESSION['Imie']=$wiersz['Imie'];
					$_SESSION['Nazwisko']=$wiersz['Nazwisko'];
					$_SESSION['KlientID']=$wiersz['KlientID'];
					
					unset($_SESSION['blad']);

					header('Location:zalogowany.php');

                        $result->close();
					}
                    else
                    {
                        $_SESSION['blad']= '<span style="color:red">Nieprawidlowy login lub haslo</span>';
                        header('Location: log.php');
                    }
			    }

			}
		else{
			$_SESSION['blad']= '<span style="color:red">Nieprawidlowy login lub haslo</span>';
			header('Location: log.php');
		}

		
	}

	
	$polaczenie->close();
	





?>
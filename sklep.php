<?php
session_start();
require_once "connect.php";
$connect = new mysqli($host,$db_user,$db_password,$db_name);
if(isset($_POST["add"]))
{
    if(isset($_SESSION["cart"]))
    {
        $item_array_id = array_column($_SESSION["cart"], "ProduktID");
        if(!in_array($_GET["ProduktID"], $item_array_id))
        {
            $count = count($_SESSION["cart"]);
            $item_array = array(
                'ProduktID' => $_GET["ProduktID"],
                'Nazwa' => $_POST["hidden_name"],
                'cena_jednostkowa' => $_POST["hidden_price"],
                'stan_magazynowy' => $_POST["quantity"]
            );
            $_SESSION["cart"][$count] = $item_array;
            echo '<script>window.location="index.php"</script>';
        }
        else
        {
            echo '<script>alert("Produkt jest już dodany")</script>';
            echo '<script>window.location="index.php"</script>';
        }
    }
    else
    {
        $item_array = array(
            'ProduktID' => $_GET["ProduktID"],
            'Nazwa' => $_POST["hidden_name"],
            'cena_jednostkowa' => $_POST["hidden_price"],
            'stan_magazynowy' => $_POST["quantity"]
        );
        $_SESSION["cart"][0] = $item_array;
        echo '<script>window.location="index.php"</script>';


    }
}
if(isset($_GET["action"]))
{
    if($_GET["action"] == "delete")
    {
        foreach($_SESSION["cart"] as $keys => $values)
        {
            if($values["ProduktID"] == $_GET["ProduktID"])
            {
                unset($_SESSION["cart"][$keys]);
                echo '<script>alert("Produkt został usunięty")</script>';
                echo '<script>window.location="index.php"</script>';
            }
        }
    }
}
?>
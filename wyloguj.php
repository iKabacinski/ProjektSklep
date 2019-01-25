<?php
session_start();
require_once "connect.php";

if(isset($_SESSION['KlientID'])){
    unset($_SESSION['KlientID']);
    echo '<script>alert("Zostałeś wylogowany")</script>';
    echo '<script>window.location="index.php"</script>';
}
else{
    echo '<script>alert("Nie jesteś zalogowany")</script>';
    echo '<script>window.location="index.php"</script>';
}
?>
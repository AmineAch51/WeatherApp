<?php
   session_start(); 
?>

<?php
    unset($_SESSION["connect"]);

    header("Location: home.php");
?>
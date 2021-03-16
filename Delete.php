<?php
    session_start();
    if(!isset($_POST["id"]) || !isset($_POST["city"])) {
        header("Location: home.php");
    }
?>
<?php
    $id=$_POST["id"];
    $city=$_POST["city"];
    $m = mysqli_connect("localhost", "root", "123soloraja", "Weather");
    $query = "delete from city where idUser=$id and NameOfCity='$city'";
    mysqli_query($m, $query);
    mysqli_close($m);
    header("Location: home.php");
?>
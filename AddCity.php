<?php
    session_start();
?>
<h1>AddCity</h1>
<?php
    function getIdUser($email) {
        $m = mysqli_connect("localhost", "root", "123soloraja", "Weather");
        $query = "select idUser from User where email='$email'";
        $result = mysqli_query($m, $query);
        while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            mysqli_close($m);
            return $row[0];
        }
    } 
    function CityExist($id, $city) {
        $m = mysqli_connect("localhost", "root", "123soloraja", "Weather");
        $query = "select * from city where idUser=$id and NameOfCity='$city'";
        $result = mysqli_query($m, $query);
        while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            mysqli_close($m);
            return true;
        }
        mysqli_close($m);
        return false;
    }   
    if(isset($_POST["city"])) {
        $city=$_POST["city"];
        $_SESSION["city"] = $city;
        $id = getIdUser($_SESSION["connect"]);
        if(!CityExist($id, $city)) {
            echo "Yes you can addet";
            $m = mysqli_connect("localhost", "root", "123soloraja", "Weather");
            $query = "insert into city(idUser, NameOfCity) values($id, '$city')";
            mysqli_query($m, $query);
            mysqli_close($m);
        }
        header("Location: home.php");
    }else {
        header("Location: home.php");
    }
?>
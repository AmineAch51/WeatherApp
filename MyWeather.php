<?php
    session_start();
    if(!isset($_SESSION["connect"])) {
        header("Location: home.php");
    }
    function getIdUser($email) {
        $m = mysqli_connect("localhost", "root", "123soloraja", "Weather");
        $query = "select idUser from User where email='$email'";
        $result = mysqli_query($m, $query);
        while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            mysqli_close($m);
            return $row[0];
        }
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/MyWeather.css">
    <title>Document</title>
</head>
<body>
    <?php
       $color = array("#16a085", 
                      "#f1c40f", 
                      "#e67e22",
                      "#e74c3c", 
                      "#3498db", 
                      "#9b59b6", 
                      "#00cec9", 
                      "#fd79a8", 
                      "#a29bfe", 
                      "#22a6b3", 
                      "#eb4d4b", 
                      "#30336b", 
                      "#B33771", 
                      "#25CCF7");
       shuffle($color);
       $p = 0;               
       $id = getIdUser($_SESSION["connect"]);
       $m = mysqli_connect("localhost", "root", "123soloraja", "Weather");
       $query = "select * from city where idUser='$id'";
       $result = mysqli_query($m, $query);
       echo "<div class='gr'>";
       while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
           echo "<div class='_c' style='background-color: $color[$p];'>". $row[2] .
           "<div class='_x'>X</div>".
            "</div>";
           ++$p;
       }
       echo "</div>";
       mysqli_close($m);
    ?>
</body>
</html>
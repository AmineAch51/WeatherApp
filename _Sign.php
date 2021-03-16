<?php
      session_start();
?>
<?php
    if(!isset($_POST["FullName"]) && 
       !isset($_POST["email"]) &&
       !isset($_POST["password"])) {
        header("Location: Sign.php");
    }
    $m = mysqli_connect("localhost", "root", "123soloraja", "Weather");
    function EmailExist($email) {
        $m = mysqli_connect("localhost", "root", "123soloraja", "Weather");
        $query = "select * from User where email='$email'";
        $result = mysqli_query($m, $query);
        while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            mysqli_close($m);
            return true;
        }
        mysqli_close($m);
        return false;

    }
    function AccountExist($email, $password) {
        $m = mysqli_connect("localhost", "root", "123soloraja", "Weather");
        $query = "select * from User where email='$email' and password='$password'";
        $result = mysqli_query($m, $query);
        while($row  = mysqli_fetch_array($result, MYSQLI_NUM)) {
            mysqli_close($m);
            return true;
        }
        mysqli_close($m);
        return false;
    }
    if($m) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $_SESSION["email"] = $email;
        if(isset($_POST["FullName"])) {
            $_SESSION["FullName"] = $_POST["FullName"];
            if(EmailExist($email)) {
                mysqli_close($m);
                $_SESSION["ErrorEmailAlreadyExist"] = "*****";
                header("Location: Sign.php");
            }else {
                $FullName = $_POST["FullName"];
                $query = "insert into User(FullName, Email, password, Type) values('$FullName', '$email', '$password', 0)";
                mysqli_query($m, $query);
                mysqli_close($m);
                header("Location: Sign.php");
            }    
        }else {
            if(!EmailExist($email)) {
                mysqli_close($m);
                $_SESSION["ErrorEmailDontExist"] = "*****";
                header("Location: Sign.php");
            }else {
                if(AccountExist($email, $password)) {
                    mysqli_close($m);
                    $_SESSION["connect"] = $email;
                    header("Location: home.php");
                }else {
                    mysqli_close($m);
                    $_SESSION["ErrorPasswordIncorrect"] = "*****";
                    header("Location: Sign.php");
                }
            }
        }
    }else {
        echo "It didn't work but never give up son :>";
    }
?>
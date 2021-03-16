<?php
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/Sign.css">
    <title>Document</title>
</head>
<body>
    <div id="boss" class="boss">
        <div class="son">
            <div class="first">
                <?php
                    if(isset( $_SESSION["ErrorEmailAlreadyExist"] )) {
                        echo "<div v-once style='display: none;'>";
                        echo "{{ SetTypeSign(false) }}";
                        echo "</div>";
                    }
                    if(isset( $_SESSION["email"] )) {
                        $email = $_SESSION["email"];
                        echo "<div v-once style='display: none;'>{{ SetEmail('$email') }}</div>";
                        unset( $_SESSION["email"] );
                    }
                    if(isset( $_SESSION["FullName"] )) {
                        $FullName = $_SESSION["FullName"];
                        echo "<div v-once style='display: none;'>{{ SetFullName('$FullName') }}</div>";
                        unset( $_SESSION["FullName"] );
                    }
                ?>
                <div class="cn0">
                    <div class="first_first" v-if="TypeSign">
                        <div><a class="Weight" v-on:click="SetTypeSign(true)">Sign In</a></div>
                        <div><a class="hr" v-on:click="SetTypeSign(false)">SignUp</a></div>
                    </div>
                    <div class="first_first" v-else>
                        <div><a class="hr" v-on:click="SetTypeSign(true)">Sign In</a></div>
                        <div><a class="Weight" v-on:click="SetTypeSign(false)">SignUp</a></div>
                    </div>
                </div>
                <div class="cn1" v-if="TypeSign">
                    <form method="POST" action="_Sign.php" id="_form">
                        <label for="" style="color: white;">Email</label></br></br>
                        <input type="email" name="email" id="_email" v-on:keydown="RemoveMsgError('EmailErr')" v-model:value="Email">
                        <div class="Err" id="EmailErr" style="display: none;">Error ! email not valid</div></br></br>
                        <label for="" style="color: white;">password</label></br></br>
                        <input type="password" name="password" id="_password" v-on:keydown="RemoveMsgError('PasswordErr')" v-model:value="Password">
                        <div class="Err" id="PasswordErr" style="display: none;">Error ! password not valid</div>
                    </form>
                </div>
                <div class="cn1" v-else>
                    <form method="POST" action="_Sign.php" id="_form">
                        <label for="" style="color: white;">Full name</label></br></br>
                        <input type="text" name="FullName" id="_name" v-on:keydown="RemoveMsgError('NameErr')" v-model:value="FullName">
                        <div class="Err" id="NameErr" style="display: none;">Error ! full name not valid</div></br></br>
                        <label for="" style="color: white;">Email</label></br></br>
                        <input type="email" name="email" id="_email" v-on:keydown="RemoveMsgError('EmailErr')" v-model:value="Email">
                        <div class="Err" id="EmailErr" style="display: none;">Error ! email not valid</div></br></br>
                        <label for="" style="color: white;">password</label></br></br>
                        <input type="password" name="password" id="_password" v-on:keydown="RemoveMsgError('PasswordErr')" v-model:value="Password">
                        <div class="Err" id="PasswordErr" style="display: none;">Error ! password not valid</div></br></br>
                        <label for="" style="color: white;">Confirm password</label></br></br>
                        <input type="password" id="cfpass" v-on:keydown="RemoveMsgError('CPasswordErr')" v-model:value="Cpassword">
                        <div class="Err" id="CPasswordErr" style="display: none;">Error ! password not valid</div>
                    </form>
                </div>
                <div class="cn2">
                    <div class="btsg" id="btsg" v-on:click.left="CheckAll()">{{ TypeSign?'Sign In':'SignUp' }}</div>
                </div>
            </div>
        </div>
    </div>
    <div id="EmailAlreadyExist" style="display: none;">
        <?php
            if(isset( $_SESSION["ErrorEmailAlreadyExist"] )) {
                echo $_SESSION["ErrorEmailAlreadyExist"];
                unset( $_SESSION["ErrorEmailAlreadyExist"] );
            }
        ?> 
    </div>
    <div id="EmailDontExist" style="display: none;">
       <?php
            if(isset($_SESSION["ErrorEmailDontExist"])) {
                echo $_SESSION["ErrorEmailDontExist"];
                unset( $_SESSION["ErrorEmailDontExist"] ); 
            }
       ?>
    </div>
    <div id="PasswordIncorrect" style="display: none;">
       <?php
            if(isset($_SESSION["ErrorPasswordIncorrect"])) {
                echo $_SESSION["ErrorPasswordIncorrect"];
                unset( $_SESSION["ErrorPasswordIncorrect"] ); 
            }
       ?>
    </div>
</body>
<script src="./scripts/vue.js"></script>
<script src="./scripts/Sign.js"></script>
</html>
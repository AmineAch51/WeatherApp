<?php
    session_start();
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
    <link rel="stylesheet" href="./styles/home.css">
    <link rel="stylesheet" href="./styles/nav.css">
    <link rel="stylesheet" href="./styles/MyWeather.css">
    <title>Document</title>
</head>
<body>
    <div id="boss" class="boss">
       <div class="son">
         <div class="nav">
             <div class="wt">Wheater app</div>
             <div class="menu">
                <a href="home.php">Home</a>
             </div>
             <div class="cnlg">
                <?php
                    if(isset($_SESSION["connect"])) {
                        echo "<div class='dc' v-on:click='Disconnect()'>Disconnect</div>";
                    }else {
                        echo "<div class='lg' v-on:click.left='GoPageSign()'>Login</div>";
                    }
                ?>
             </div>
         </div>
         <div class="barSearch">
             <div class="cn_bar_search">
                <input type="text" placeholder="City" id="ct"/>
                <div class="bt" id="bt" v-on:click="ChangeCity()">Search</div>
             </div>
         </div>
         <div class="con1">
             
             <div v-if="weather.length!==0" class="con2" v-bind:style="backPic">

                 <div class="first" id="cn1">
                     <div class="first_first">
                         <h2 class="h_1">{{ getMonth() }}</h2>
                         <div></div>
                         <h2 class="h_2">{{ getDay() }}</h2>
                     </div>
                     <div class="first_second">
                         <div class="first_second_first">
                            <h2 class="h_1">{{ getTemp() }}</h2>
                            <div>°</div>
                         </div>
                         <h2 class="h_2" style="text-align: center;">{{ city }}</h2>
                     </div>
                 </div>

                <div class="con3" id="cn2">
                    <div class="_con3" style="width: 100%;">
                        <div class="state">
                            <div class="d1">
                                <h1 style="font-size: 21px; text-align: center;">{{ getSituationTitle() }}</h1>
                                <label style="text-align: center; margin-top: 10px;">Wind : N {{ getWind() }} mph</label>  
                                <label style="text-align: center;">Speed : {{ getSpeed() }}</label>   
                                <label style="text-align: center;">Humidity : {{ getHumidity() }}%</label> 
                                <label style="text-align: center;">Visibility : {{ getVisibility() }} </label>
                                <div style="margin-left: 65px;" class="mid2"></div>
                            </div>  
                            <div class="mid1"></div>
                        </div>
    
                        <div class="_wheater">
                            <div v-for="(w,index) in weather">
                                    <wheater-pic 
                                    v-bind:_temp=w.main.temp
                                    v-bind:_date=w.dt_txt
                                    v-bind:_weath_sit=w.weather[0].description
                                    v-bind:_ind=index
                                    ></wheater-pic>
                            </div>
                        </div>

                    </div>


                </div>
          </div>
          <div v-else  class="con2" v-bind:style="ApiStillFetching" >
          </div>
         </div>
         <div v-once>
             {{ getLatLng() }}
             {{ getApiCity() }}
             {{ getWeatherApi() }}
         </div>
         <div style="display: flex; justify-content: center;">
            <div class="addBt" <?php if(!isset($_SESSION["connect"])) { echo "v-on:click='GoPageSign()'"; } else { echo "v-on:click='GoAddCity()'"; } ?> >
               <div class="plusSign" style="font-size: 25px;">+</div>
               <div style="font-size: 26px;">Add City</div>
            </div>
         </div>
         <div style="display: none;">
            <div id="Curr">0</div>
            <button id="h_curr" v-on:click='setCurrentIndex()'></button>
         </div>
         <form method="POST" action="AddCity.php" style="display: none;">
              <input type="text" name="city" id="addCity">
              <button id="btAddCity"></button>
         </form>
         <?php
              /*if(isset( $_SESSION["city"] )) {
                  $city = $_SESSION["city"];
                  echo "<div v-once style='display: none;'>{{ SetCity('$city') }}</div>";
                  unset( $_SESSION["city"] );
              }*/
         ?>

    <?php   
            if(isset($_SESSION["connect"])) {  
                        $color = array( "#16a085", 
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
                                        "#25CCF7" );
                        shuffle($color);
                        $p = 0;          
                        $id = getIdUser($_SESSION["connect"]);
                        $m = mysqli_connect("localhost", "root", "123soloraja", "Weather");
                        $query = "select * from city where idUser='$id'";
                        $result = mysqli_query($m, $query);
                        echo "<div class='gr'>";
                        while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                            //$str="$id, $row[2]";
                               // echo "<div class='_c' style='background-color: $color[$p];'>". $row[2];
                                  ?>
                                    <div v-on:click="_ChangeCity(<?php echo "'$row[2]'"; ?>)" class='_c' style='background-color: <?php echo "$color[$p]"; ?>'> <?php echo "$row[2]"; ?>
                                            <div class='_x' v-on:click="DeleteCity( <?php echo "$id,'$row[2]'"; ?> )">X</div>
                                    </div>
                                  <?php
                            ++$p;
                        }
                        echo "</div>";
                        mysqli_close($m);
            }
    ?>
    <div style="display: none;">
        <form method="POST" action="Delete.php">
            <input type="text" name="id" id="id"/>
            <input type="text" name="city" id="city"/>
            <button id="Delete"></button>
        </form>
    </div>
   </div>
 </div>
</body>
<script src="./scripts/vue.js"></script>
<script src="./scripts/home.js"></script>
</html>
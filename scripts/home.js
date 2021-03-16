Vue.component("wheater-pic", {
    data: function() {
        return {}
    },
    props: ["_temp", "_date", "_weath_sit", "_ind"],
    methods: {
         getDay: function(i=1) {
             let day = i;
             if(day>7) { day=(day%7); }
             switch(day) {
                 case 1: return "Mon";
                 case 2: return "Tue";
                 case 3: return "Wed";
                 case 4: return "Thu";
                 case 5: return "Fri";
                 case 6: return "Sat";
             }
             return "Sun";
         },
         getWeatherPic: function() {
             let pic = "002-full moon.png",
                 sit = this._weath_sit 
             if(sit === "broken clouds") {
                 return "./pictures/WeatherIcons/png/010-cloudy day.png";
             }
             if(sit === "overcast clouds") {
                return "./pictures/WeatherIcons/png/026-cloud.png";
             }
             if(sit === "light snow") {
                return "./pictures/WeatherIcons/png/045-snow.png";
             }
             if(sit === "light rain") {
                return "./pictures/WeatherIcons/png/035-rainy day.png";
             }
             if(sit === "scattered clouds") {
                return "./pictures/WeatherIcons/png/010-cloudy day.png";
             }
             if(sit === "clear sky") {
                return "./pictures/WeatherIcons/png/044-sunny.png";
             }
             if(sit === "few clouds") {
                return "./pictures/WeatherIcons/png/010-cloudy day.png";
             }
             if(sit === "snow") {
                return "./pictures/WeatherIcons/png/028-snow.png";
             }
             if(sit === "moderate rain") {
                return "./pictures/WeatherIcons/png/035-rainy day.png";
             }
             if(sit === "heavy intensity rain") {
                return "./pictures/WeatherIcons/png/023-rain.png";
             }
             return `./pictures/WeatherIcons/png/${pic}`;
         },
         setCurrentIndex: function() {
             document.getElementById("Curr").textContent=this._ind;
             document.getElementById("h_curr").click();
         }
    },
    template: "<div class='WeatherComponent' style='cursor: pointer; line-height: 30px; padding: 0 15px; margin-bottom: 60px;' v-on:click='setCurrentIndex()'>"+
                   "<h3 style='text-align: center;'>"+ "{{ getDay(new Date(_date).getDay()) }}" +"</h3>"+
                   "<img style='height: 50px; margin-top: 15px;' v-bind:src='getWeatherPic()'/>"+
                   "<div style='text-align: center;'>"+
                       "{{ Math.round(+_temp) }}"+  
                       "<img style='height: 30px; width: 30px; margin-top: 10px; margin-left: 10px;' src='./pictures/WeatherIcons/png/046-centigrade.png'>"+
                   "</div>"+
              "</div>"
});

let _boss_ = new Vue({
    el: "#boss",
    data: {
        backPic: "background-image: url(./pictures/Weather4.png);",
        ApiStillFetching: "background-image: url(./pictures/Trex1.png);",
        weather: [],
        CurrentIndex: 0,
        lat: "",
        lng: "",
        city: "",
        _Effect: false,
        LocationData: ""
    },
    methods: {
        getDay: function(i=1) {
            let day = i;
            if(day>7) { day=(day%7); }
            switch(day) {
                case 1: return "Mon";
                case 2: return "Tue";
                case 3: return "Wed";
                case 4: return "Thu";
                case 5: return "Fri";
                case 6: return "Sat";
            }
            return "Sun";
        },
        getLatLng: function() {
            if(typeof(this.city)==="string" &&
               this.city.length!==0) { return; }
            let v=undefined;
            function sc(position) {
                v=position;
            }
            function err(_err) {
                return _err;
            }
            navigator.geolocation.getCurrentPosition(sc, err);
            let timer = setInterval(()=>{
                if(typeof(this.city)==="string" &&
                this.city.length!==0) { clearInterval(timer); }
                if(v!==undefined) {
                    this.lat = v.coords.latitude;
                    this.lng = v.coords.longitude;
                    clearInterval(timer);
                }
            }, 1000);
        },
        getApiCity: function() {
            let timer = setInterval(()=> {
                if(typeof(this.city)==="string" &&
                this.city.length!==0) { clearInterval(timer); }
                if(typeof(this.lat)==="number" &&
                   typeof(this.lng)==="number") {
                   fetch(`https://api.opencagedata.com/geocode/v1/json?q=${this.lat}+${this.lng}&key=94b64bb4fafa40b2b22dd8a926030482`).
                   then(res=> {
                        return res.json();
                   }).then(data=> {
                        this.LocationData=data;
                        this.city=data.results[0].components.county;
                        console.log(this.city);
                        console.log(this.LocationData);
                        clearInterval(timer);
                   }).catch(function(err) {
                   });
                }
            }, 1000);
        },
        getWeatherApi: function() {
            let timer = setInterval(()=> {
                if(typeof(this.city)==="string" && this.city.length!==0) {
                    fetch(`https://api.openweathermap.org/data/2.5/forecast?q=${this.city}&appid=e3969ac032ae453e751e85e1b3af9dbd&units=metric`).
                    then(res=> {
                        return res.json();
                    }).then(data=> {
                        if( typeof(data)!=="object" ||
                            data.message==="city not found") {
                            this.city = this.LocationData.results[0].components.region.split("-")[0];
                            this.getWeatherApi();
                        }else {
                            let m = {}, t=[], y;
                            for(let i=0; i<data.list.length; ++i) {
                                y=data.list[i].dt_txt.split(' ');
                                if(y[0] in m) { } 
                                else {
                                    t.push(data.list[i]);
                                    m[y[0]] = 1;
                                }
                            }
                            this.weather = t;
                        }
                        clearInterval(timer);
                    }).catch(function(err) {
                        
                    });
                }
            }, 1000);
        },
        getMonth: function() {
            return new Date(this.weather[this.CurrentIndex].dt_txt)
                   .toString().split(' ')[1];
        },
        getDay: function() {
            return new Date(this.weather[this.CurrentIndex].dt_txt)
            .toString().split(' ')[2];
        }, 
        getTemp: function() {
            return Math.round(this.weather[this.CurrentIndex]
                   .main.temp);  
        },
        getWind: function() {
            return this.weather[this.CurrentIndex]
                   .wind.deg; 
        },
        getSpeed: function() {
            return this.weather[this.CurrentIndex]
                   .wind.speed;
        },
        getHumidity: function() {
            return this.weather[this.CurrentIndex]
                   .main.humidity;
        },
        getVisibility: function() {
            return this.weather[this.CurrentIndex]
                       .visibility;
        },
        getSituationTitle: function() {
            return this.weather[this.CurrentIndex]
                   .weather[0].description;
        },
        setCurrentIndex: function() {
            this.Effect();
        },
        Effect: function() {
            if(this._Effect) { return; }
            this._Effect=true;
            let id = "cn1", 
                i=1,
                v=true;
            let timer = setInterval(()=> {
                if(v) {
                    if(i<=0) {
                        this.CurrentIndex = +document.getElementById("Curr").textContent;
                        v=false;
                    }
                    i-=0.01;
                    document.getElementById("cn1").style.opacity = i.toString();
                    document.getElementById("cn2").style.opacity = i.toString();
                }else {
                    if(i>=1) {
                        this._Effect=false;
                        clearInterval(timer);
                    }
                    i+=0.01;
                    document.getElementById("cn1").style.opacity = i.toString();
                    document.getElementById("cn2").style.opacity = i.toString();
                }
            });
        },
        ChangeCity: function(s) {
            if(typeof(s)!=="string")
                s = document.getElementById("ct").value = document.getElementById("ct").value.trim();
            if(s.length===0) { return; }
            this.city = s;
            document.getElementById("ct").value="";
            this.weather=[];
            this.getWeatherApi();
        },
        GoPageSign: function() {
            window.open("Sign.php", "_self");
        },
        GoAddCity: function() {
            if(typeof(this.weather)!=="object" || this.weather.length===0 ||
               typeof(this.city)!=="string" || this.city.length===0) { return; }
            document.getElementById("addCity").value = this.city;
            document.getElementById("btAddCity").click();
        },
        SetCity: function(s) {
            this.city = s;
        },
        Disconnect: function() {
            window.open("Disconnect.php", "_self");
        },
        DeleteCity: function(id, city) {
            document.getElementById("id").value=id;
            document.getElementById("city").value=city;
            document.getElementById("Delete").click();
        },
        _ChangeCity: function(s) {
            this.ChangeCity(s);
        }
    }
});

window.onkeydown = function (event) {
    let key_press = this.String.fromCharCode(event.keyCode);
    if (key_press.charCodeAt()===13) {
        document.getElementById("bt").click();
    }
}
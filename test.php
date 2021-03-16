<script>
    let data = "Abidjan ACCRA Adana ADDIS ABABA Adelaide Agra Ahmadabad Aleppo(Halab) Alexandria ALGIERS Allahabad ALMATY AMMAN Amritsar ANKARA Anshan BAGHDAD Baku Bandung Bangalore BANGKOK Baotou Barcelona Barquisimeto Barranquilla Basrah BEIJING BEIRUT Belem BELGRADE Belo Horizonte Benghazi Benin BERLIN Bhopal Birmingham BOGOTA BRASILIA BRAZZAVILLE Brisbane BUCHAREST BUDAPEST BUENOS AIRES Bursa Busan CAIRO Cali Campinas Capetown CARACAS Casablanca Changchun Changsha Changzhou Chelyabinsk Chengdu Chennai Chicago Chittagong Chongquin Ciudad Juarez CONAKRY COPENHAGEN Cordoba Curitiba Daegu Daejon DAKAR Dalian Dallas DAMASCUS DAR ES SALAAM Datong DELHI DHAKA Dnipropetrovsk Donetsk Douala Durban Ecatepec Ekaterinburg Faisalabad Fortaleza Foshan FREETOWN Fukuoka Fuzhou Giza Goiania Guadalajara Guangzhou Guarulhos GUATAMALA CITY Guayaquil Guiyang Gujranwala Gwangju Haiphong Hamburg Handan Hangzhou HANOI Haora HARARE Harbin HAVANA Hefei Hiroshima Ho Chi Minh City Hong Kong Houston Hyderabad Hyderabad Ibadan Incheon Indore Irbil Isfahen Istanbul Izmir Jaipur JAKARTA Jeddah Jilin Jinan Jodphur Johannesburg KABUL Kaduna Kano Kanpur Kaohsiung Karachi Kawasaki Kazan Kharkiv KHARTOUM Khulna KIEV KINSHASA Kitakyushu Kobe Kolkata Kowloon KUALA LUMPUR Kunming Kyoto LA PAZ Lagos Lahore Lanzhou Leon LIMA LONDON Los Angeles LUANDA Lubumbashi Lucknow Ludhiana Luoyang LUSAKA MADRID Maiduguri Makassar MANAGUA Manaus MANILA MAPUTO Maracaibo Mashhad Mecca Medan Medellin Medina Meerut Melbourne Mexicali MEXICO CITY Milan MINSK MOGADISHU Monterrey MONTEVIDEO Montreal MOSCOW Mosul Multan Mumbai (Bombay) Munich Nagoya Nagpur NAIROBI Nanchang Nanjing Nanning Napoli Nashik New York City Nezahualcoyotl Nizhny Novgorod Novosibirsk Odessa Omdurman Omsk Osaka Palembang PARIS Patna Perm Perth Peshawar Philadelphia PHNOM PENH Phoenix Pimpri Chinchwad Port Harcourt PORT-AU-PRINCE Porto Alegre PRAGUE Puebla Pune PYONGYANG Qingdao Qiqihar QUITO RABAT Rajkot Ranchi Rawalpindi Recife Rio de Janeiro RIYADH ROME Rosario Rostov on Don Salvador Samara San Antonio San Diego SANAA Santa Cruz SANTIAGO SANTO DOMINGO Sao Paulo Sapporo Semarang Sendai Seongnam Seoul Shanghai Shenyang Shenzhen Shiraz Shiziahuang Shubra El Kheima SINGAPORE SOFIA Soweto St Petersburg STOCKHOLM Surabaya Surat Suzhou Sydney Tabriz Taichung TAIPEI Taiyuan Tangshan TASHKENT TBILISI Tegucigalpa TEHRAN Tianjin Tijuana TOKYO Toronto TRIPOLI TSHWANE (PRETORIA) TUNIS Ufa Ulsan Urumqi Vadodara Valencia Varanasi VIENNA Volgograd WARSAW Wuhan Wuxi Xian Xuzhou Yangon YAOUNDE Yerevan Yokohama Zapopan Zhengzhou Zibo";
    let i = 0,
        timer,
        v=undefined,
        m={},
        result=[],
        t=[
        "Amsterdam",
        "Athens",    
        "Baghdad",
        "Bangkok",
        "Barcelona",
        "Beijing",
        "Belgrade",
        "Berlin",
        "Bogota",
        "Bratislava",
        "Brussels",
        "Bucharest",
        "Budapest",
        "Buenos Aires",
        "Cairo",
        "Cape Town",
        "Caracas",
        "Chicago",
        "Copenhagen",
        "Dhaka",
        "Dubai",
        "Dublin",
        "Frankfurt",
        "Geneva",
        "The Hague",
        "Hanoi",
        "Helsinki",
        "Hong Kong",
        "Istanbul",
        "Jakarta",
        "Jerusalem",
        "Johannesburg",
        "Kabul",
        "Karachi",
        "Kiev",
        "Kuala Lumpur",
        "Lagos",
        "Lahore",
        "Lima",
        "Lisbon",
        "Ljubljana",
        "London",
        "Los Angeles",
        "Luxembourg",
        "Madrid",
        "Marrakesh",
        "Manila",
        "Mexico City",
        "Montreal",
        "Moscow",
        "Mumbai ",
        "Nairobi",
        "New Delhi ",
        "New York ",
        "Nicosia",
        "Oslo",
        "Ottawa",
        "Paris",
        "Prague",
        "Reykjavik",
        "Riga",
        "Rio de Janeiro",
        "Rome",
        "Saint Petersburg",
        "San Francisco",
        "Santiago ",
        "São Paulo",
        "Seoul",
        "Shanghai",
        "Singapore",
        "Sofia",
        "Stockholm",
        "Sydney",
        "Tallinn",
        "Tehran",
        "Tokyo",
        "Toronto",
        "Venice",
        "Vienna",
        "Vilnius",
        "Warsaw",
        "Washington",
        "Wellington",
        "Zagreb"
        ]
        timer = setInterval(()=> {
            if(i>=t.length) {
                console.log("-------------------------------Finish-------------------------------");
                t.sort((x, y)=> {
                    if(x>y) { return 1; }
                    if(x<y) { return -1; }
                    return 0;
                });
                let s="";
                for(let j = 0; j<result.length; ++j) {
                    s+=result[j]+'&';
                }
                console.log(result);
                console.log(s);
                clearInterval(timer);
            }
            fetch(`https://api.openweathermap.org/data/2.5/forecast?q=${t[i]}&appid=e3969ac032ae453e751e85e1b3af9dbd&units=metric`).
            then(res=> {
                return res.json();
            }).then(data=> {
                v = data;
            });
            if(v!==undefined) {
                if(v.list!==undefined) {
                    for(let j = 0; j<v.list.length; ++j) {
                        //console.log(v.list[j].weather[0].description);
                        if(v.list[j].weather[0].description in m) {}
                        else {
                            m[v.list[j].weather[0].description]=1;
                            result.push(v.list[j].weather[0].description);
                        }
                    }
                }
                v=undefined;
                ++i;
            }
        }, 500);  
</script>
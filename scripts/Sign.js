/////////////////////////////////////////////////////
function isLower(c) {
    return c>='a'&&c<='z';
}
function isUpper(c) {
    return c>='A'&&c<='Z';
}
function isNumber(c) {
    return c>='0'&&c<='9';
}
function isAlphabetic(c) {
    return isLower(c)||isUpper(c);
}
function isAlphabeticNumeric(c) {
    return isLower(c)||isUpper(c)||isNumber(c);
}
////////////////////////////////////////////////////
////////////////////////////////////////////////////
function isName(s) {
    if(typeof(s)!=="string") { return false; }
    let state = 0;
    for(let i=0; i<s.length; ++i) {
        if(state===0) {
            if(!isAlphabetic(s[i])) { return false; }
            state=1;
        } else if(state===1) {
            if(!isAlphabetic(s[i])) { return false; }
            state=2;
        } else {
            if(s[i]===' ') { state=0; }
            else if(!isAlphabeticNumeric(s[i])) { return false; }
        }
    }
    return state===2;
}
function isEmail(s) {
    if(typeof(s)!=="string") { return false; }
    let state = 0;
    for(let i=0; i<s.length; ++i) {
        if(state===0) {
            if(!isAlphabetic(s[i])) { return false; }
            state=1;
        }else if(state===1) {
            if(!isAlphabetic(s[i])) { return false; }
            state=2;
        }else if(state===2) {
            if(s[i]==='.') { state=0; }
            else if(s[i]=='@') { state=3; }
            else if(!isAlphabeticNumeric(s[i])) { return false; }
        }else if(state===3) {
            if(!isAlphabetic(s[i])) { return false; }
            state=4;
        }else if(state===4) {
            if(!isAlphabetic(s[i])) { return false; }
            state=5;
        }else if(state===5) {
            if(s[i]==='.') { state=6; }
            else if(!isAlphabeticNumeric(s[i])) { return false; }
        }else if(state===6) {
            if(!isAlphabetic(s[i])) { return false; }
            state=7;
        }else if(state===7) {
            if(!isAlphabetic(s[i])) { return false; }
            state=8;
        }else {
            if(s[i]==='.') { state=6; }
            else if(!isAlphabeticNumeric(s[i])) { return false; }
        }
    }
    return state===8;
}
////////////////////////////////////////////////////
let _boss_ = new Vue({
    el: "#boss",
    data: {
        TypeSign: true,
        FullName: "",
        Email: "",
        Password: "",
        Cpassword: ""
    },
    methods: {
        SetTypeSign: function(v) {
            if(!v) {
                this.RemoveMsgError("EmailErr");
                this.RemoveMsgError("PasswordErr");
            }else {
                this.RemoveMsgError("NameErr");
                this.RemoveMsgError("EmailErr");
                this.RemoveMsgError("PasswordErr");
            }
            this.TypeSign=v;
        },
        CheckAll: function() {
            let v = true,
                idEmail = "_email",
                idPassword = "_password",
                idErrorEmail = "EmailErr",
                idErrorPassword = "PasswordErr",
                idName = "_name",
                idErrorName = "NameErr";
            if(!this.TypeSign) {
                if(!isName( document.getElementById(idName).value )) {
                    document.getElementById(idErrorName).setAttribute("style", ""); 
                    v=false;
                }
                if( document.getElementById("cfpass").value !== 
                    document.getElementById(idPassword).value) {
                    document.getElementById("CPasswordErr").setAttribute("style", ""); 
                    v=false;
                }
            }    
            if( !isEmail( document.getElementById(idEmail).value ) ) {
                document.getElementById(idErrorEmail).textContent = "Error ! email not valid";
                document.getElementById(idErrorEmail).setAttribute("style", ""); 
                v=false;
            }    
            if(document.getElementById(idPassword).value.length<6) {
                document.getElementById(idErrorPassword).textContent = "Error ! password not valid";
                document.getElementById(idErrorPassword).setAttribute("style", "");
                v=false;
            }
            if(v) {
                let bt = document.createElement("button");
                bt.style.display = "none"
                document.getElementById("_form").appendChild(bt);
                document.getElementById("_form").lastElementChild.click();
            }
        },
        RemoveMsgError: function(id) {
            document.getElementById(id).setAttribute("style", "display: none;");
        },
        SetEmail: function(s) {
            this.Email = s;
        },
        SetFullName: function(s) {
            this.FullName = s;
        }
    }
});
window.onkeydown = function (event) {
    let key_press = this.String.fromCharCode(event.keyCode);
    if (key_press.charCodeAt() === 13) {
        document.getElementById("btsg").click();
    }
}
if(document.getElementById("EmailAlreadyExist").textContent.trim().length!==0) {
    document.getElementById("EmailAlreadyExist").textContent = "";
    document.getElementById("EmailErr").textContent = "Error ! email alredy exist";
    document.getElementById("EmailErr").setAttribute("style", "");
}
if(document.getElementById("EmailDontExist").textContent.trim().length!==0) {
    document.getElementById("EmailDontExist").textContent = "";
    document.getElementById("EmailErr").textContent = "Error ! email doesn't exist";
    document.getElementById("EmailErr").setAttribute("style", "");
}
if(document.getElementById("PasswordIncorrect").textContent.trim().length!==0) {
    document.getElementById("PasswordIncorrect").textContent = "";
    document.getElementById("PasswordErr").textContent = "Error ! password incorrect";
    document.getElementById("PasswordErr").setAttribute("style", "");
}
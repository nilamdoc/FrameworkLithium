<div  style="background-image:url(/img/globe.png);background-color:#D8F0BF;height:500px;background-repeat:no-repeat;background-attachment: fixed;background-position: left ; " >
<div class="container text-left" style="padding:30px">
<form method="post">
 <div class="row" style="margin-bottom:-5px;">
  <div class="col-9">
  </div>
  <div class="col oswald size32" style="border-bottom:double">Register</div>
 </div>
 <div class="row">
  <div class="col-9">
  </div>
  <div class="col field">
     <input type="email" class="form-control inEmail" id="email" name="email" aria-describedby="emailHelp" required placeholder=" ">
     <label for="email">Email Address</label>
    <small id="emailHelp" class="form-text text-muted">Write your email address.</small>
    </div>
 </div>
 <div class="row">
  <div class="col-9">
  </div>
  <div class=" col field">
     <input type="password" class="form-control inPassword" id="password" name="password" aria-describedby="passwordHelp" required placeholder="      ">
     <label for="password">Password</label>
     <small id="passwordHelp" class="form-text text-muted">Strong Password.</small>
     <meter max="4" id="password-strength-meter"></meter>
     <p id="password-strength-text"></p>
  </div>
 </div>
 <div class="row">
  <div class="col-9">
  </div>
  <div class=" col field">
  <button type="submit" name="submit" class="btn btn-outline-success">Register</button>
  </div>
 </div>
 
</form>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>
<script>
var strength = {
        0: "Worst ☹",
        1: "Bad ☹",
        2: "Weak ☹",
        3: "Good ☺",
        4: "Strong ☻"
}

var password = document.getElementById('password');
var meter = document.getElementById('password-strength-meter');
var text = document.getElementById('password-strength-text');

password.addEventListener('input', function()
{
    var val = password.value;
    var result = zxcvbn(val);
    // Update the password strength meter
    meter.value = result.score;
   
    // Update the text indicator
    if(val !== "") {
        text.innerHTML = "Strength: " + "<strong>" + strength[result.score] + "</strong>" + "<span class='feedback'>" + result.feedback.warning + " " + result.feedback.suggestions + "</span"; 
    }
    else {
        text.innerHTML = "";
    }
});</script>
<style>
.field {
  padding-top: 0px;
  display: flex;
  flex-direction: column;
}
label {
  order: -1;
  padding-left: 15px;
  transition: all 0.3s ease-in;
  transform: translateY(40px);
  pointer-events: none;
}
input:focus + label {
  padding-left: 2px;
  transform: translateY(5px);
}
.inEmail:placeholder-shown + label{
  order: -1;
  padding-left: 15px;
  transition: all 0.3s ease-in;
  transform: translateY(40px);
  pointer-events: none;
}
.inEmail:not(:placeholder-shown) + label {
  padding-left: 2px;
  transform: translateY(5px);
}

.inPassword:placeholder-shown + label{
  order: -1;
  padding-left: 15px;
  transition: all 0.3s ease-in;
  transform: translateY(40px);
  pointer-events: none;
}
.inPassword:not(:placeholder-shown) + label {
  padding-left: 2px;
  transform: translateY(5px);
}
meter {
    /* Reset the default appearance */
    -webkit-appearance: none;
       -moz-appearance: none;
            appearance: none;
            
    margin: 0 auto 1em;
    width: 100%;
    height: .5em;
    
    /* Applicable only to Firefox */
    background: none;
    background-color: rgba(0,0,0,0.1);
}
meter::-webkit-meter-bar {
    background: none;
    background-color: rgba(0,0,0,0.1);
}

meter[value="1"]::-webkit-meter-optimum-value { background: red; }
meter[value="2"]::-webkit-meter-optimum-value { background: yellow; }
meter[value="3"]::-webkit-meter-optimum-value { background: orange; }
meter[value="4"]::-webkit-meter-optimum-value { background: green; }

meter[value="1"]::-moz-meter-bar { background: red; }
meter[value="2"]::-moz-meter-bar { background: yellow; }
meter[value="3"]::-moz-meter-bar { background: orange; }
meter[value="4"]::-moz-meter-bar { background: green; }

.feedback {
    color: #9ab;
    font-size: 90%;
    padding: 0 .25em;
    font-family: Courgette, cursive;
    margin-top: 1em;
}
</style>

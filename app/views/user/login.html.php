<div  style="background-image:url(/img/globe.png);background-color:#D8F0BF;height:500px;background-repeat:no-repeat;background-attachment: fixed;background-position: left ; " >
<div class="container text-left" style="padding:30px">
<form method="post">
 <div class="row" style="margin-bottom:-5px;">
  <div class="col-9">
  </div>
  <div class="col oswald size32" style="border-bottom:double">Login</div>
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
     <small id="passwordHelp" class="form-text text-muted">Your password.</small>
  </div>
 </div>
 <div class="row" style="margin-top:20px">
  <div class="col-9">
  </div>
  <div class=" col field">
  <button type="submit" name="submit" class="btn btn-outline-success">Login</button>
  </br>Still not registered!
   <a href="/user/register/" class="btn btn-outline-success " role="button" aria-pressed="true">Register</a>&nbsp;&nbsp;

  </div>
 </div>
 
</form>
</div>
</div>
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
</style>
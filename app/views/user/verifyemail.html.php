<div  style="background-image:url(/img/globe.png);background-color:#D8F0BF;height:500px;background-repeat:no-repeat;background-attachment: fixed;background-position: left ; " >
<div class="container text-left" style="padding:30px">
<form method="post">
 <div class="row" style="margin-bottom:15px;">
  <div class="col-9">
  </div>
  <div class="col oswald size32" style="border-bottom:double">Verify</div>
 </div>
 <div class="row">
  <div class="col-9">
  </div>
  <?php if($verify=="Verified!"){?>  
  <div class="col">
   <p>&nbsp;</p>
   <h5> Your email is verified!</h5>
   <p><a href="/user/login/" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">Click to login</a></p>
  </div>
  <?php }else{?>
  <div class="col field">
     <input type="text" class="form-control inEmailcode" id="emailcode" name="emailcode" aria-describedby="emailcodeHelp" required placeholder=" ">
     <label for="emailcode">Email Code</label>
    <small id="emailcodeHelp" class="form-text text-muted">Write code received in email.</small>
  </div>
  <?php }?>
 </div>
  <?php if($verify!="Verified!"){?>
  <div class="row">
  <div class="col-9">
  </div>
  <div class=" col field">
  <button type="submit" name="submit" class="btn btn-outline-success">Verify</button>
  </div>
 </div>
  <?php }?>
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
.inEmailcode:placeholder-shown + label{
  order: -1;
  padding-left: 15px;
  transition: all 0.3s ease-in;
  transform: translateY(40px);
  pointer-events: none;
}
.inEmailcode:not(:placeholder-shown) + label {
  padding-left: 2px;
  transform: translateY(5px);
}

</style>
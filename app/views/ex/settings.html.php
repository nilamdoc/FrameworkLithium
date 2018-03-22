<div class="container size20" style="background-color:#D8F0BF;">
<form method="post">
 <div class="row" style="margin-bottom:5px;border-bottom:double">
  <div class="col-6 oswald size32">Personal</div>
  <div class="col-6"></div>
 </div>
 <div class="row" style="border-bottom:1px dotted;padding:5px">
  <div class="col-2" style="">Name</div>
  <div class="col-6"><input type="text" class="form-control" name="Name" id="Name" value="<?=$user['Name']?>"></div>
  <div class="col"></div>
 </div>
 <div class="row" style="border-bottom:1px dotted;padding:5px">
  <div class="col-2" style="">Email</div>
  <div class="col-6"><input type="text" class="form-control" name="Name" id="Name" value="<?=$user['email']?>" disabled></div>
  <div class="col"><?=$user['email_verify']?></div>
 </div>
 <div class="row" style="border-bottom:1px dotted;padding:5px">
  <div class="col-2" style="">Mobile</div>
  <div class="col-2" style="">
  <select class="form-control" name="Country" id="Country" >
  <?php foreach($countries as $c){?>
  <option value="<?=$c['Phone']?>" <?php if($c['Phone']==$user['Country']){echo ' selected ';}?> ><?=$c['Country']?> (<?=$c['Phone']?>)</option>
  <?php }?>
  </select>
  </div>
  <div class="col-4"><input type="text" class="form-control" name="Mobile" id="Mobile" value="<?=$user['Mobile']?>"></div>
  <div class="col"><?=$user['mobile_verify']?></div>
 </div>
  <div class="row" style="margin-bottom:5px;border-bottom:double">
  <div class="col-6 oswald size32">Stellar Account</div>
  <div class="col-6"></div>
 </div>
 <div class="row" style="border-bottom:1px dotted;padding:5px">
   <div class="col-2" style="">Stellar Network</div>
   <div class="col-6">
    <div class="btn-group " >
     <label class="">
       <input type="radio" name="Network" value="Test" id="Test" onclick="SelectedNetwork('Test')" <?php if($user['Network']=="Test"){ echo " checked ";} ?>> Test &nbsp;
     </label>
     <label class="">
       <input type="radio" name="Network" value="Public" id="Public" onclick="SelectedNetwork('Public')" <?php if($user['Network']=="Public"){ echo " checked ";} ?>> Public
     </label>
    </div>
    <span id="SelectedNet">
    <?php  if($user['Network']=="Test"){ echo "https://horizon-testnet.stellar.org";}else{echo "https://horizon.stellar.org";}?>
    </span>
   </div>
   <div class="col"></div>
  </div>
  <div class="row" style="border-bottom:1px dotted;padding:5px">
   <div class="col-2" style="">Account</div>
   <div class="col-6"><input type="text" class="form-control" name="Account" id="Account" value="<?=$user['pubkey']?>" readonly></div>
   <div class="col"><button class="btn btn-outline-success" onclick="CopyText('Account')">Copy text</button></div>
  </div>
  <div class="row" style="border-bottom:1px dotted;padding:5px">
   <div class="col-2" style="">Secret</div>
   <div class="col-6"><input type="password" class="form-control" name="Secret" id="Secret" value="<?=$user['prikey']?>" readonly></div>
   <div class="col">
   <button class="btn btn-outline-success" onclick="CopyText('Secret')">Copy text</button>
   <input class="btn btn-outline-success" type="checkbox" onclick="ShowPassword('Secret')"> <small>Show</small>
   </div>
  </div>
 <div class="row" style="margin-bottom:5px;padding:5px;border-bottom:double">
  <div class="col-2">
  </div>
  <div class=" col field">
  <button type="submit" name="submit" class="btn btn-success">Save</button>
  </div>
 </div>
</form>
</div>
<script>
function ShowPassword(id) {
    var x = document.getElementById(id);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
} 
function CopyText(id) {
  var copyText = document.getElementById(id);
  copyText.select();
  document.execCommand("Copy");
} 
function SelectedNetwork(sel){
 var x = document.getElementById('SelectedNet');
 if(sel=="Test"){
  x.innerHTML = "https://horizon-testnet.stellar.org";
  
 }else{
  x.innerHTML = "https://horizon.stellar.org";
  
 }
 
}
</script>
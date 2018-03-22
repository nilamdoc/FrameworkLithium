<?php 
use app\models\Users;

use lithium\storage\Session;
  $user = Session::read('default');
  $conditions = array(
   'email'=>strtolower($user['email']),
   'secret'=>$user['secret']
  );
  $user = Users::find('first',array(
   'conditions'=>$conditions
  ));
  if(count($user)>0){
 ?>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 border-bottom box-shadow">
  <h5 class="my-0 mr-md-auto font-weight-normal">Hitarth.io</h5>
  <nav class="my-2 my-md-0 mr-md-3">
  <ul class="nav ">
   <li class="nav-item dropdown">
     <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Stellar</a>
     <div class="dropdown-menu" aria-labelledby="dropdown01">
       <a class="dropdown-item" href="/stellar/createAccount">Create Account</a>
       <a class="dropdown-item" href="#">Transact</a>
       <a class="dropdown-item" href="#">Assets</a>
     </div>
   </li>
   <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profile</a>
     <div class="dropdown-menu" aria-labelledby="dropdown02">
       <a class="dropdown-item" href="/ex/settings">Settings</a>
       <a class="dropdown-item" href="/ex/logout/">Logout</a>
     </div>
   </li>
  </ul>
 </nav>

</div>
<?php }else{?>
<h1 style="text-align:center">Stellar Lumens to INR through USD, GBP, EUR, CAD</h1>
<?php }?>